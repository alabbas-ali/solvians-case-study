/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Alabbas
 * Created: Sep 14, 2016
 */

CREATE TABLE TradingMarket (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    xname varchar(100) NOT NULL , 
    active BOOLEAN NOT NULL DEFAULT '1'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO TradingMarket (xname) VALUES ('Frankfurt');
INSERT INTO TradingMarket (xname) VALUES ('London');
INSERT INTO TradingMarket (xname) VALUES ('Brussels');
INSERT INTO TradingMarket (xname) VALUES ('Paris');
INSERT INTO TradingMarket (xname) VALUES ('Berlin');

CREATE TABLE Issuer (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    xname varchar(100) NOT NULL , 
    active BOOLEAN NOT NULL DEFAULT '1'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Issuer (xname) VALUES ('American Express');
INSERT INTO Issuer (xname) VALUES ('VISA');
INSERT INTO Issuer (xname) VALUES ('Wells Fargo');
INSERT INTO Issuer (xname) VALUES ('USAA');
INSERT INTO Issuer (xname) VALUES ('U.S. Bank');

CREATE TABLE Currency (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    xname varchar(100) NOT NULL ,
    code varchar(3) NOT NULL,
    symbol varchar(1) NOT NULL , 
    active BOOLEAN NOT NULL DEFAULT '1'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Currency (xname , code, symbol) VALUES ('Dollar' , 'USD', '$');
INSERT INTO Currency (xname , code, symbol) VALUES ('Euro', 'EUR', '€');
INSERT INTO Currency (xname , code, symbol) VALUES ('Fiji Dollar' , 'FJD' ,'$');
INSERT INTO Currency (xname , code, symbol) VALUES ('Pound' , 'FKP' ,'£');

CREATE TABLE DocumentType (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    xname varchar(100) NOT NULL ,
    active BOOLEAN NOT NULL DEFAULT '1'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO DocumentType (xname) VALUES ('pdf');
INSERT INTO DocumentType (xname) VALUES ('docx');

CREATE TABLE Certificate (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    ISIN varchar(12) UNIQUE NOT NULL , 
    market_id INTEGER NOT NULL , 
    currency_id INTEGER NOT NULL , 
    issuer_id INTEGER NOT NULL , 
    issuerprice FLOAT NOT NULL , 
    currentprice FLOAT NOT NULL , 
    certificatetype INTEGER NOT NULL , 
    active BOOLEAN NOT NULL DEFAULT '1',
    KEY certificatetype (certificatetype)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Certificate ( ISIN , market_id , currency_id , issuer_id , issuerprice , currentprice , certificatetype) VALUES ( 'US0000RGDRT7' , 1 , 2 , 3 , 45.36 , 46.99 , 1 );
INSERT INTO Certificate ( ISIN , market_id , currency_id , issuer_id , issuerprice , currentprice , certificatetype) VALUES ( 'US0378331005' , 2 , 3 , 1 , 45.36 , 46.99 , 1 );
INSERT INTO Certificate ( ISIN , market_id , currency_id , issuer_id , issuerprice , currentprice , certificatetype) VALUES ( 'US0000RGDRT8' , 3 , 2 , 2 , 45.36 , 46.99 , 2 );
INSERT INTO Certificate ( ISIN , market_id , currency_id , issuer_id , issuerprice , currentprice , certificatetype) VALUES ( 'US0000RGDRT9' , 4 , 3 , 3 , 45.36 , 46.99 , 2 );
INSERT INTO Certificate ( ISIN , market_id , currency_id , issuer_id , issuerprice , currentprice , certificatetype) VALUES ( 'US0000RGDRT6' , 2 , 4 , 4 , 45.36 , 46.99 , 3 );
INSERT INTO Certificate ( ISIN , market_id , currency_id , issuer_id , issuerprice , currentprice , certificatetype) VALUES ( 'US0000RGDRT4' , 3 , 3 , 1 , 45.36 , 46.99 , 3 );

CREATE TABLE BonusCertificate(
    id int(11) NOT NULL PRIMARY KEY,
    barrierlevel FLOAT NOT NULL,
    hit BOOLEAN NOT NULL,
    CONSTRAINT FK_5659A201BF396750 FOREIGN KEY (id) REFERENCES certificate (id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO BonusCertificate ( certificate_id , barrierlevel , hit ) VALUES ( 3, 99.99 , true );
INSERT INTO BonusCertificate ( certificate_id , barrierlevel , hit ) VALUES ( 4, 99.99 , false);


CREATE TABLE GuaranteeCertificate(
    id int(11) NOT NULL PRIMARY KEY,
    participationrate INT(3) NOT NULL,
    CONSTRAINT FK_5659A201BF396750 FOREIGN KEY (id) REFERENCES certificate (id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO GuaranteeCertificate ( certificate_id , participationrate  ) VALUES ( 5 , 99 );
INSERT INTO GuaranteeCertificate ( certificate_id , participationrate  ) VALUES ( 6 , 65 );

CREATE TABLE Document (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    xname varchar(100) NOT NULL , 
    xpath varchar(255) NOT NULL ,
    documenttype_id INTEGER NOT NULL, 
    certificate_id INTEGER NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 1' ,'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf' , 1 , 1);
INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 2' ,'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf' , 1 , 1);
INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 3' ,'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf' , 1 , 2);
INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 4' ,'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf' , 1 , 2);
INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 5' ,'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf' , 1 , 2);
INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 6' ,'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf' , 1 , 3);
INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 7' ,'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf' , 1 , 3);
INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 8' ,'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf' , 1 , 3);
INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 9' ,'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf' , 1 , 4);
INSERT INTO Document (xname ,xpath ,documenttype_id , certificate_id) VALUES ('doc 11' ,'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf' , 1 , 4);

CREATE TABLE PriceHistory (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    certificate_id INTEGER NOT NULL , 
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP  , 
    price FLOAT NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO PriceHistory ( certificate_id  , price) VALUES ( 1, 15.46 );
INSERT INTO PriceHistory ( certificate_id  , price) VALUES ( 4, 24.35 );
INSERT INTO PriceHistory ( certificate_id  , price) VALUES ( 2, 20.65 );
INSERT INTO PriceHistory ( certificate_id  , price) VALUES ( 3, 48.56 );
INSERT INTO PriceHistory ( certificate_id  , price) VALUES ( 4, 13.35 );
INSERT INTO PriceHistory ( certificate_id  , price) VALUES ( 3, 88.34 );
INSERT INTO PriceHistory ( certificate_id  , price) VALUES ( 1, 99.99 );