# Inserimento anni scolastici di prova.
INSERT INTO year VALUES(null, "2019-09-01", "2020-01-25", "2020-01-26", "2020-06-29");
INSERT INTO year VALUES(null, "2018-09-01", "2019-01-25", "2019-01-26", "2019-06-29");
INSERT INTO year VALUES(null, "2017-09-01", "2018-01-25", "2018-01-26", "2018-06-29");
INSERT INTO year VALUES(null, "2016-09-01", "2017-01-25", "2017-01-26", "2017-06-29");

# Inserimento sezioni di prova.
INSERT INTO section VALUES("SAM I1AA", 0);
INSERT INTO section VALUES("SAM I2AA", 0);
INSERT INTO section VALUES("SAM I3AA", 0);
INSERT INTO section VALUES("SAM I4AA", 0);
INSERT INTO section VALUES("SAM I1AB", 0);
INSERT INTO section VALUES("SAM I2AB", 0);
INSERT INTO section VALUES("SAM I3AB", 0);
INSERT INTO section VALUES("SAM I4AB", 0);
INSERT INTO section VALUES("SAM D1AA", 0);
INSERT INTO section VALUES("SAM D2AA", 0);
INSERT INTO section VALUES("SAM D3AA", 0);
INSERT INTO section VALUES("SAM D4AA", 0);
INSERT INTO section VALUES("SAM D1AB", 0);
INSERT INTO section VALUES("SAM D2AB", 0);
INSERT INTO section VALUES("SAM D3AB", 0);
INSERT INTO section VALUES("SAM D4AB", 0);
INSERT INTO section VALUES("SAM E1AA", 0);
INSERT INTO section VALUES("SAM E2AA", 0);
INSERT INTO section VALUES("SAM E3AA", 0);
INSERT INTO section VALUES("SAM E4AA", 0);
INSERT INTO section VALUES("SAM E1AB", 0);
INSERT INTO section VALUES("SAM E2AB", 0);
INSERT INTO section VALUES("SAM E3AB", 0);
INSERT INTO section VALUES("SAM E4AB", 0);

# Inserimento studenti e ritardi di prova.
INSERT INTO student VALUES(null, "fulvio.larocca@samtrevano.ch", "Fulvio", "Larocca", "SAM E4AB", 2);
INSERT INTO delay VALUES(null, 1, "2019-02-09", "Lo ha bloccato la polizia", null, 0);
INSERT INTO delay VALUES(null, 1, "2019-03-12", "", null, 0);
INSERT INTO delay VALUES(null, 1, "2019-05-22", "", null, 0);
INSERT INTO student VALUES(null, "dionigi.gambardella@samtrevano.ch", "Dionigi", "Gambardella", "SAM D3AA", 3);
INSERT INTO delay VALUES(null, 2, "2018-03-02", "Causa sveglia", null, 0);
INSERT INTO delay VALUES(null, 2, "2018-02-02", "Lo ha bloccato la polizia", null, 0);
INSERT INTO delay VALUES(null, 2, "2018-02-12", "Ritardo bus", null, 0);
INSERT INTO student VALUES(null, "saul.ciardullo@samtrevano.ch", "Saul", "Ciardullo", "SAM E2AA", 2);
INSERT INTO delay VALUES(null, 3, "2019-05-26", "Ritardo bus", null, 0);
INSERT INTO delay VALUES(null, 3, "2019-02-17", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO student VALUES(null, "proteo.celano@samtrevano.ch", "Proteo", "Celano", "SAM I2AB", 1);
INSERT INTO delay VALUES(null, 4, "2020-02-05", "Lo ha bloccato la polizia", null, 0);
INSERT INTO delay VALUES(null, 4, "2020-02-04", "Finito la benzina", null, 0);
INSERT INTO delay VALUES(null, 4, "2020-04-02", "Ritardo treni", null, 0);
INSERT INTO student VALUES(null, "aidano.gillotti@samtrevano.ch", "Aidano", "Gillotti", "SAM E4AA", 2);
INSERT INTO delay VALUES(null, 5, "2019-03-25", "", null, 0);
INSERT INTO delay VALUES(null, 5, "2019-02-03", "Si è scordato di venire a lezione", null, 0);
INSERT INTO delay VALUES(null, 5, "2019-03-01", "Il bus ha fatto un incidente", null, 0);
INSERT INTO student VALUES(null, "telchide.cornelio@samtrevano.ch", "Telchide", "Cornelio", "SAM D1AB", 3);
INSERT INTO delay VALUES(null, 6, "2018-03-08", "Ha preso il bus sbagliato", null, 0);
INSERT INTO delay VALUES(null, 6, "2018-05-07", "Causa sveglia", null, 0);
INSERT INTO student VALUES(null, "arminio.angello@samtrevano.ch", "Arminio", "Angello", "SAM I1AB", 1);
INSERT INTO delay VALUES(null, 7, "2020-04-26", "Ritardo bus", null, 0);
INSERT INTO delay VALUES(null, 7, "2020-02-02", "Ritardo bus", null, 0);
INSERT INTO student VALUES(null, "aleramo.capparelli@samtrevano.ch", "Aleramo", "Capparelli", "SAM D4AB", 1);
INSERT INTO delay VALUES(null, 8, "2020-02-14", "Arrivato in ritardo perchè aveva dimenticato il materiale", null, 0);
INSERT INTO delay VALUES(null, 8, "2020-05-27", "Posto di blocco", null, 0);
INSERT INTO delay VALUES(null, 8, "2020-04-14", "Ritardo bus", null, 0);
INSERT INTO delay VALUES(null, 8, "2020-02-03", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO student VALUES(null, "sicuro.nuti@samtrevano.ch", "Sicuro", "Nuti", "SAM D3AB", 4);
INSERT INTO delay VALUES(null, 9, "2017-04-25", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO delay VALUES(null, 9, "2017-02-25", "Aveva dimenticato il materiale", null, 0);
INSERT INTO student VALUES(null, "vedasto.tabacchi@samtrevano.ch", "Vedasto", "Tabacchi", "SAM I4AA", 4);
INSERT INTO delay VALUES(null, 10, "2017-03-22", "Ha preso il bus sbagliato", null, 0);
INSERT INTO delay VALUES(null, 10, "2017-05-04", "Posto di blocco", null, 0);
INSERT INTO delay VALUES(null, 10, "2017-04-07", "Il bus ha fatto un incidente", null, 0);
INSERT INTO student VALUES(null, "piero.bracci@samtrevano.ch", "Piero", "Bracci", "SAM E1AB", 2);
INSERT INTO delay VALUES(null, 11, "2019-05-06", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO delay VALUES(null, 11, "2019-05-15", "Arrivato in ritardo perchè aveva dimenticato il materiale", null, 0);
INSERT INTO student VALUES(null, "mirco.errigo@samtrevano.ch", "Mirco", "Errigo", "SAM E2AB", 4);
INSERT INTO delay VALUES(null, 12, "2017-05-03", "", null, 0);
INSERT INTO delay VALUES(null, 12, "2017-03-02", "Causa sveglia", null, 0);
INSERT INTO delay VALUES(null, 12, "2017-03-13", "Ritardo bus", null, 0);
INSERT INTO student VALUES(null, "salvo.giampa@samtrevano.ch", "Salvo", "Giampa", "SAM E1AB", 4);
INSERT INTO delay VALUES(null, 13, "2017-03-15", "Il treno è stato soppresso", null, 0);
INSERT INTO delay VALUES(null, 13, "2017-05-08", "Ritardo bus", null, 0);
INSERT INTO delay VALUES(null, 13, "2017-02-23", "Aveva sbagliato aula", null, 0);
INSERT INTO student VALUES(null, "azelia.pontarelli@samtrevano.ch", "Azelia", "Pontarelli", "SAM E1AA", 3);
INSERT INTO delay VALUES(null, 14, "2018-05-23", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO delay VALUES(null, 14, "2018-05-03", "", null, 0);
INSERT INTO student VALUES(null, "melissa.lagorio@samtrevano.ch", "Melissa", "Lagorio", "SAM D3AA", 1);
INSERT INTO delay VALUES(null, 15, "2020-04-02", "Il treno ha avuto un guasto", null, 0);
INSERT INTO delay VALUES(null, 15, "2020-03-24", "", null, 0);
INSERT INTO delay VALUES(null, 15, "2020-04-26", "Ha preso il bus sbagliato", null, 0);
INSERT INTO delay VALUES(null, 15, "2020-02-14", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO student VALUES(null, "amelia.torregrossa@samtrevano.ch", "Amelia", "Torregrossa", "SAM I1AB", 2);
INSERT INTO delay VALUES(null, 16, "2019-05-17", "", null, 0);
INSERT INTO delay VALUES(null, 16, "2019-03-27", "Lo ha bloccato la polizia", null, 0);
INSERT INTO student VALUES(null, "iris.ratto@samtrevano.ch", "Iris", "Ratto", "SAM E2AA", 2);
INSERT INTO delay VALUES(null, 17, "2019-03-08", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO student VALUES(null, "alcina.paternostro@samtrevano.ch", "Alcina", "Paternostro", "SAM I1AA", 1);
INSERT INTO delay VALUES(null, 18, "2020-05-16", "Posto di blocco", null, 0);
INSERT INTO delay VALUES(null, 18, "2020-03-11", "", null, 0);
INSERT INTO student VALUES(null, "gioconda.massucci@samtrevano.ch", "Gioconda", "Massucci", "SAM E3AB", 1);
INSERT INTO delay VALUES(null, 19, "2020-02-02", "", null, 0);
INSERT INTO student VALUES(null, "zosima.lasco@samtrevano.ch", "Zosima", "Lasco", "SAM D1AA", 4);
INSERT INTO delay VALUES(null, 20, "2017-02-07", "", null, 0);
INSERT INTO delay VALUES(null, 20, "2017-04-30", "Si è scordato di venire a lezione", null, 0);
INSERT INTO delay VALUES(null, 20, "2017-04-26", "Finito la benzina", null, 0);
INSERT INTO student VALUES(null, "cleo.cascella@samtrevano.ch", "Cleo", "Cascella", "SAM E2AA", 2);
INSERT INTO delay VALUES(null, 21, "2019-05-04", "Posto di blocco", null, 0);
INSERT INTO delay VALUES(null, 21, "2019-01-28", "Lo ha bloccato la polizia", null, 0);
INSERT INTO student VALUES(null, "norina.marte@samtrevano.ch", "Norina", "Marte", "SAM E4AA", 3);
INSERT INTO delay VALUES(null, 22, "2018-05-27", "Il bus ha fatto un incidente", null, 0);
INSERT INTO delay VALUES(null, 22, "2018-03-29", "Posto di blocco", null, 0);
INSERT INTO delay VALUES(null, 22, "2018-03-27", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO delay VALUES(null, 22, "2018-05-22", "Lo ha bloccato la polizia", null, 0);
INSERT INTO student VALUES(null, "bartolomeo.milia@samtrevano.ch", "Bartolomeo", "Milia", "SAM E3AA", 1);
INSERT INTO delay VALUES(null, 23, "2020-04-22", "Il bus ha fatto un incidente", null, 0);
INSERT INTO delay VALUES(null, 23, "2020-02-19", "Causa sveglia", null, 0);
INSERT INTO delay VALUES(null, 23, "2020-03-13", "", null, 0);
INSERT INTO student VALUES(null, "venanzio.natali@samtrevano.ch", "Venanzio", "Natali", "SAM E2AB", 2);
INSERT INTO delay VALUES(null, 24, "2019-05-09", "Il treno è stato soppresso", null, 0);
INSERT INTO student VALUES(null, "zaccaria.traina@samtrevano.ch", "Zaccaria", "Traina", "SAM I4AA", 4);
INSERT INTO delay VALUES(null, 25, "2017-05-20", "Ha preso il bus sbagliato", null, 0);
INSERT INTO delay VALUES(null, 25, "2017-03-06", "Il treno è stato soppresso", null, 0);
INSERT INTO student VALUES(null, "eligio.biondo@samtrevano.ch", "Eligio", "Biondo", "SAM E1AA", 2);
INSERT INTO delay VALUES(null, 26, "2019-03-07", "Il treno ha avuto un guasto", null, 0);
INSERT INTO student VALUES(null, "meneo.federico@samtrevano.ch", "Meneo", "Federico", "SAM E4AA", 3);
INSERT INTO delay VALUES(null, 27, "2018-03-17", "Ha preso il bus sbagliato", null, 0);
INSERT INTO delay VALUES(null, 27, "2018-05-23", "Ha preso il bus sbagliato", null, 0);
INSERT INTO student VALUES(null, "ermanno.patron@samtrevano.ch", "Ermanno", "Patron", "SAM I4AB", 4);
INSERT INTO delay VALUES(null, 28, "2017-02-23", "Si è scordato di venire a lezione", null, 0);
INSERT INTO delay VALUES(null, 28, "2017-04-04", "Ritardo bus", null, 0);
INSERT INTO student VALUES(null, "cosimo.rinaldo@samtrevano.ch", "Cosimo", "Rinaldo", "SAM D1AB", 2);
INSERT INTO delay VALUES(null, 29, "2019-03-29", "", null, 0);
INSERT INTO delay VALUES(null, 29, "2019-05-17", "", null, 0);
INSERT INTO student VALUES(null, "pasquale.brigandi@samtrevano.ch", "Pasquale", "Brigandi", "SAM D2AB", 2);
INSERT INTO delay VALUES(null, 30, "2019-05-04", "Arrivato in ritardo perchè aveva dimenticato il materiale", null, 0);
INSERT INTO delay VALUES(null, 30, "2019-04-04", "Il treno è stato soppresso", null, 0);
INSERT INTO student VALUES(null, "saverio.carone@samtrevano.ch", "Saverio", "Carone", "SAM D2AA", 3);
INSERT INTO delay VALUES(null, 31, "2018-05-15", "", null, 0);
INSERT INTO delay VALUES(null, 31, "2018-04-12", "Il bus ha fatto un incidente", null, 0);
INSERT INTO delay VALUES(null, 31, "2018-04-17", "Ritardo treni", null, 0);
INSERT INTO delay VALUES(null, 31, "2018-04-19", "Ritardo treni", null, 0);
INSERT INTO student VALUES(null, "lanfranco.gencarelli@samtrevano.ch", "Lanfranco", "Gencarelli", "SAM E4AA", 4);
INSERT INTO delay VALUES(null, 32, "2017-05-14", "Causa sveglia", null, 0);
INSERT INTO delay VALUES(null, 32, "2017-02-04", "Posto di blocco", null, 0);
INSERT INTO delay VALUES(null, 32, "2017-03-27", "Posto di blocco", null, 0);
INSERT INTO delay VALUES(null, 32, "2017-03-13", "Si è scordato di venire a lezione", null, 0);
INSERT INTO delay VALUES(null, 32, "2017-04-30", "Posto di blocco", null, 0);
INSERT INTO student VALUES(null, "ursino.militello@samtrevano.ch", "Ursino", "Militello", "SAM D4AB", 3);
INSERT INTO delay VALUES(null, 33, "2018-04-19", "Lo ha bloccato la polizia", null, 0);
INSERT INTO delay VALUES(null, 33, "2018-02-15", "Si è scordato di venire a lezione", null, 0);
INSERT INTO delay VALUES(null, 33, "2018-04-23", "", null, 0);
INSERT INTO student VALUES(null, "odorico.milano@samtrevano.ch", "Odorico", "Milano", "SAM D2AA", 2);
INSERT INTO delay VALUES(null, 34, "2019-02-02", "Lo ha bloccato la polizia", null, 0);
INSERT INTO delay VALUES(null, 34, "2019-02-05", "Finito la benzina", null, 0);
INSERT INTO delay VALUES(null, 34, "2019-05-12", "Ritardo bus", null, 0);
INSERT INTO student VALUES(null, "uberto.laudicina@samtrevano.ch", "Uberto", "Laudicina", "SAM I4AB", 1);
INSERT INTO delay VALUES(null, 35, "2020-02-04", "Ritardo treni", null, 0);
INSERT INTO delay VALUES(null, 35, "2020-02-05", "Ritardo bus", null, 0);
INSERT INTO delay VALUES(null, 35, "2020-03-24", "Aveva sbagliato aula", null, 0);
INSERT INTO delay VALUES(null, 35, "2020-05-14", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO student VALUES(null, "andrea.patane@samtrevano.ch", "Andrea", "Patane", "SAM I4AB", 2);
INSERT INTO delay VALUES(null, 36, "2019-03-13", "Ritardo bus", null, 0);
INSERT INTO student VALUES(null, "fleano.maddaloni@samtrevano.ch", "Fleano", "Maddaloni", "SAM D1AA", 3);
INSERT INTO delay VALUES(null, 37, "2018-02-01", "Posto di blocco", null, 0);
INSERT INTO delay VALUES(null, 37, "2018-04-26", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);
INSERT INTO delay VALUES(null, 37, "2018-03-27", "Arrivato in ritardo perchè aveva dimenticato il materiale", null, 0);
INSERT INTO delay VALUES(null, 37, "2018-04-29", "Aveva dimenticato il materiale", null, 0);
INSERT INTO delay VALUES(null, 37, "2018-02-03", "Aveva dimenticato il materiale", null, 0);
INSERT INTO student VALUES(null, "egisto.orsi@samtrevano.ch", "Egisto", "Orsi", "SAM E2AB", 3);
INSERT INTO delay VALUES(null, 38, "2018-03-19", "Si è scordato di venire a lezione", null, 0);
INSERT INTO delay VALUES(null, 38, "2018-05-23", "Aveva dimenticato il materiale", null, 0);
INSERT INTO student VALUES(null, "mariano.boccuzzi@samtrevano.ch", "Mariano", "Boccuzzi", "SAM I2AA", 3);
INSERT INTO delay VALUES(null, 39, "2018-02-01", "Posto di blocco", null, 0);
INSERT INTO delay VALUES(null, 39, "2018-05-11", "Arrivato in ritardo perchè si è dimenticato l'aula", null, 0);