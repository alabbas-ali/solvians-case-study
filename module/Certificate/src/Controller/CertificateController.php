<?php

namespace Certificate\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DBALException;
use Certificate\Model\Certificate;
use Certificate\Model\GuaranteeCertificate;
use Certificate\Model\BonusCertificate;
use Certificate\Service\CertificateService;
use Certificate\Form\CertificateForm;
use Market\Model\Market;
use Currency\Model\Currency;
use Issuer\Model\Issuer;


/* * 
 * Description of CertificateController
 *
 * @author Alabbas
 */

class CertificateController extends AbstractActionController {

    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    protected $emanager;

    /**
     *
     * @var Certificate\Service\CertificateService 
     */
    protected $certservice;

    public function __construct(EntityManager $em) {
        $this->emanager = $em;
        $this->certservice = new CertificateService($this->emanager);
    }

    /**
     * the function handle the operation of returning page of Certificate to 
     * be displayed, to use the function Use POST with the paramentrs 
     * Start : number of the page 
     * Length : number of the requested result 
     * Order : array of Ordering parametrs where index 'column' is the order
     *          column name and 'dir' is the 'asc' or 'desc'
     * the function returm JSON Object :
     * [  "draw" => $draw,
     *    "recordsTotal" => Total number of results in BD,
     *    "recordsFiltered" => Total number of returned result,
     *    "data" => $data
     *   ]
     * @return JsonModel
     */
    public function getAllAction() {
        $draw = $this->getRequest()->getPost('draw', 1);
        $start = $this->getRequest()->getPost('start', 0);
        $length = $this->getRequest()->getPost('length', 10);
        $order = $this->getRequest()->getPost('order', null);
        $arrayff = [ "draw" => $draw, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => [] ];
        try {
            $certificates = $this->certservice->fetchOrdersPage($start, $length, $order);
            $all_count = $this->certservice->getResultCount();
        } catch (DBALException $e) {
            return new JsonModel($arrayff);
        }
        foreach ($certificates as $certificate) {
            $item = $certificate->getArrayCopy();
            $arrayff["data"][] = $item;
        }
        $arrayff["recordsTotal"] = $all_count;
        $arrayff["recordsFiltered"] = sizeof($arrayff["data"]);
        return new JsonModel($arrayff);
    }

    /**
     * This Function is the handler for displaying Certificate As HTML 
     * @return ViewModel
     */
    public function displayAsHtmlAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $certificate = $this->certservice->getCertificate($id);
        //var_dump($certificate);
        return new ViewModel(['certificate' => $certificate]);
    }

    /**
     * This Function is the handler for displaying Certificate As XML 
     * document
     * @return Response As XLM document
     * @throws \Exception
     */
    public function displayAsXmlAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        $certificate = $this->certservice->getCertificate($id);
        if (!is_a($certificate, GuaranteeCertificate::class)) {
            $data = $certificate->getArrayCopy();
            $i1 = 0;
            foreach ($certificate->documents as $doc) {
                $data['documents'][$i1] = $doc->getArrayCopy();
                $i1 ++;
            }
            $i2 = 0;
            foreach ($certificate->pricehistory as $price) {
                $data['pricehistory'][$i2] = $price->getArrayCopy();
                $i2 ++;
            }
            $xml_data = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
            $this->arrayToXml($data, $xml_data);
            $result = $xml_data->asXML();
        } else {
            throw new \Exception("Can't Rander Guarantee Certificate as XML");
        }

        $response = $this->getResponse();
        $response->getHeaders()->addHeaders(array('Content-type' => 'text/xml'));
        $response->setContent($result);
        return $response;
    }

    public function addAction() {
        $form = new CertificateForm($this->emanager);
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $certificate = new Certificate();
            $form->setInputFilter($certificate->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                if($data['certificatetype'] == 0 ){
                    $certificate = new Certificate();
                }elseif ($data['certificatetype'] == 0) {
                    $certificate = new BonusCertificate();
                    $certificate->setBarrierlevel($data['barrierlevel']);
                }else{
                    $certificate = new GuaranteeCertificate();
                    $certificate->setParticipationrate($data['participationrate']);
                }
                $data['trading_market'] = $this->emanager->find(Market::class, $data['trading_market']); 
                $data['currency'] = $this->emanager->find(Currency::class, $data['currency']);
                $data['issuer'] = $this->emanager->find(Issuer::class, $data['issuer']);
                $certificate->exchangeArray($data);
                $certificate->active = 1;
                //var_dump($certificate);
                $this->certservice->saveCertificate($certificate);
                return $this->redirect()->toRoute('home');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($this->certservice->deleteCertificate($id)) {
            $res = ["done" => 'true', 'message' => 'Certificate Have been Deletet'];
            return new JsonModel($res);
        }
        $res = ["done" => 'false', 'message' => 'Sorry But Can not Delete This'];
        return new JsonModel($res);
    }

    public function chstatusAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($this->certservice->changeCertificateActivation($id)) {
            $res = ["done" => 'true', 'message' => 'Certificate Has been Edited'];
            return new JsonModel($res);
        }
        $res = ["done" => 'false', 'message' => 'Sorry But Can not Edit This'];
        return new JsonModel($res);
    }

    /**
     * this function is responsaple of converting array to noods and inserting
     * thhis noods to SimpleXMLElement
     * 
     * @param type Array
     * @param type refreance to SimpleXMLElement
     */
    public function arrayToXml($data, &$xml_data) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $key = (is_numeric($key)) ? 'item' . $key : $key;
                $subnode = $xml_data->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

}
