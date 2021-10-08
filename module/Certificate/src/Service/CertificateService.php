<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * @author Alabbas
 */

namespace Certificate\Service;

use Certificate\Model\Certificate;
use Certificate\Model\BonusCertificate;
use Certificate\Model\GuaranteeCertificate;
use Doctrine\ORM\EntityManager;


class CertificateService {

    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    protected $emanager;
    protected $resultCount;

    public function __construct(EntityManager $em) {
        $this->emanager = $em;
    }

    function getResultCount() {
        return $this->resultCount;
    }

    public function fetchAll() {
        $resultSet = $this->emanager->getRepository(Certificate::class)->findAll();
        return $resultSet;
    }

    public function fetchJustCertificates() {
        $query = $this->emanager->createQuery("SELECT certificate FROM Certificate\Model\Certificate staff " +
                "WHERE certificate NOT INSTANCE OF Certificate\Model\BonusCertificate" +
                "AND certificate NOT INSTANCE OF Certificate\Model\GuaranteeCertificate");
        $resultSet = $query->getResult();
        return $resultSet;
    }

    public function fetchJustBonusCertificates() {
        $resultSet = $this->emanager->getRepository(BonusCertificate::class)->findAll();
        return $resultSet;
    }

    public function fetchJustGuaranteeCertificates() {
        $resultSet = $this->emanager->getRepository(GuaranteeCertificate::class)->findAll();
        return $resultSet;
    }

    public function fetchOrdersPage($start, $length, $order) {
        $qb = $this->emanager->createQueryBuilder();
        $qb->select(array('table'))->from(Certificate::class, 'table');

        $columns = [0 => 'currentprice', 1 => 'issuerprice'];
        if (isset($order)) {
            for ($i = 0, $ien = count($order); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = intval($order[$i]['column']);
                if (isset($columns[$columnIdx])) {
                    $column = $columns[$columnIdx];
                    $dir = $order[$i]['dir'] === 'asc' ? 'ASC' : 'DESC';
                    $qb->orderBy('table.' . $column, $dir);
                }
            }
        }

        $this->resultCount = count($qb->getQuery()->getResult());
        
        $qb->setFirstResult($start);
        $qb->setMaxResults($length);

        return $qb->getQuery()->getResult();
    }

    public function getCertificate($id) {
        $row = $this->emanager->find(BonusCertificate::class, $id);
        if (!$row) {
            $row = $this->emanager->find(GuaranteeCertificate::class, $id);
            if (!$row) {
                $row = $this->emanager->find(Certificate::class, $id);
                if (!$row) {
                    throw new \Exception("Could not find row $id");
                }
            }
        }
        return $row;
    }

    public function saveCertificate(Certificate $certificate) {
        $id = $certificate->__get('id');
        if ($id == null || $id == 0) {
            $this->emanager->persist($certificate);
            $this->emanager->flush();
        } else {
            if ($this->emanager->find(Certificate::class, $id)) {
                $this->emanager->merge($certificate);
                $this->emanager->flush();
            } else {
                throw new \Exception('certificate id does not exist');
            }
        }
    }

    /**
     * 
     * @param type int
     * @return boolean
     */
    public function deleteCertificate($id) {
        $cer = $this->emanager->find(Certificate::class, $id);
        if ($cer) {
            $this->emanager->remove($cer);
            $this->emanager->flush();
            return true;
        }
        return false;
    }
    
    public function changeCertificateActivation($id) {
        $cer = $this->emanager->find(Certificate::class, $id);
        if ($cer) {
            $cer->active = !$cer->active;
            $this->emanager->flush();
            return true;
        }
        return false;
    }

}
