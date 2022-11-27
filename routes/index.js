var express = require('express');
var router = express.Router();

const inscripcionController = require('../controllers/inscripcion');

/* GET home page. 
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});*/
router.get('/',                 inscripcionController.index);
/* GET /yinkanaId/index.html
router.get('/:yinkanaId(\\d+)/index.html', function(req, res, next) {
  res.render('hoja', { title: 'Express' });
});*/
router.get('/:yincanaId(\\d+)/index.html', inscripcionController.hoja);

router.post('/:yincanaId(\\d+)/create.html',inscripcionController.create);

router.get('/:yincanaId(\\d+)/comprueba', inscripcionController.comprueba);

router.get('/admin', inscripcionController.admin);

router.post('/admin/get', inscripcionController.ponSesionUser, inscripcionController.adminGet);

router.post('/admin/update', inscripcionController.ponSesionUser, inscripcionController.adminUpdate);

router.post('/admin/quitaSesionUser', inscripcionController.quitaSesionUser);

router.post('/admin/modifica', inscripcionController.ponSesionUser, inscripcionController.adminModifica);

router.post('/admin/desplaza', inscripcionController.ponSesionUser, inscripcionController.adminDesplaza);

router.get('/consulta', inscripcionController.lector);

router.post('/consulta/get', inscripcionController.ponSesionLector, inscripcionController.lectorGet);

router.get('/:yincanaId(\\d+)/ayto', inscripcionController.ayto);

router.post('/:yincanaId(\\d+)/ayto/get', inscripcionController.ponSesionAyto,inscripcionController.aytoGet);


//router.get('/quizzes/new',                 quizController.new);
//router.post('/quizzes',                    quizController.create);



module.exports = router;
