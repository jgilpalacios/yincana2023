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

//router.get('/quizzes/new',                 quizController.new);
//router.post('/quizzes',                    quizController.create);



module.exports = router;
