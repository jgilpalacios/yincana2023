const Sequelize = require("sequelize");
const Op = Sequelize.Op;
const { models } = require("../models");
//para generar las transacciones
const { sequelize } = require("../models/connection"); 

// GET / home page. 
exports.index = async (req, res, next) => {
    try {
        const nYincanas = await models.Yincana.count();
        res.render('index', { nYincanas }); 

    } catch (error) {
        console.log(error);
    }
    
};

//GET /yinkanaId/index.html
exports.hoja = async (req, res, next) => {
    let yincanaId = req.params.yincanaId;
    try {
        let yincana = await models.Yincana.findByPk(yincanaId);
        res.render('hoja', { clave_pub: yincana.clavePublica, yincanaId });
    } catch (error) {
        console.log(error);
    }
    
};

// POST /yinkanaId/create
exports.create = async (req, res, next/*, yinkanaId*/) => {

    const { clave, encr, valor } = req.body;

    //console.log('+++++++++++++++', JSON.stringify(req.params));
    let yincanaId = req.params.yincanaId;

    // First, we start a transaction from your connection and save it into a variable
    const t = await sequelize.transaction();
    //const t = await  models.transaction();

    try {
        let nsol = 1000;
        let solicitada = new Date();
        let estado = 0;

        let yincana = await models.Yincana.findByPk(yincanaId);
        if (!yincana) {
            throw new Error('There is no yincana with id=' + yincanaId);
        }
        nsol = ++yincana.nsol;
        let inscripcion = models.Inscripcion.build({
            //let inscripcion = Inscripcion.build({
            yincanaId,
            nsol,
            clave,
            encr,
            valor,
            solicitada,
            estado
        });

        // Saves only the fields question and answer into the DDBB
        //quiz = await quiz.save({fields: ["question", "answer"]});
        inscripcion = await inscripcion.save();
        yincana = await yincana.save();
        await t.commit();
        //req.flash('success', 'Quiz created successfully.');
        //res.redirect('/');
        res.send(JSON.stringify(inscripcion));
    } catch (error) {
        await t.rollback();
        console.log(error);
        /*if (error instanceof Sequelize.ValidationError) {
            req.flash('error', 'There are errors in the form:');
            error.errors.forEach(({message}) => req.flash('error', message));
            res.render('quizzes/new', {quiz});
        } else {
            req.flash('error', 'Error creating a new Quiz: ' + error.message);
            next(error);
        }*/
    }
};

//GET /yinkanaId/comprueba
exports.comprueba = async (req, res, next) => {
    let yincanaIdOrg = req.params.yincanaId;
    const {query} = req;
   
    try {
        let findOptions={};
        findOptions.where = {[Op.and]: [
            { nsol: query.contador },
            { clave: query.clave }
          ]};
        let inscripcion = await models.Inscripcion.findAll(findOptions);
        //console.log('++++++++++',JSON.stringify(inscripcion)+'\n'+inscripcion[0].yincanaId)
        let yincana = await models.Yincana.findByPk(inscripcion[0].yincanaId);
        //console.log('--------------'+JSON.stringify(yincana));
        res.render('comprueba', { yincanaIdOrg, yincanaId: inscripcion[0].yincanaId, contador: query.contador, clave: query.clave , estado: inscripcion[0].estado, yincanaNombre: yincana.utilidad, nequipo: inscripcion[0].nequipo||0 });
    
    } catch (error) {
        console.log(error);
    }
    
};

exports.admin = async (req, res, next) => {
    try {
       let yincanas = await models.Yincana.findAll();
        //console.log('+++++++++++++++++', JSON.stringify(yincanas))
        res.render('admin', { yincanas });
    } catch (error) {
        console.log(error);
    }
};

exports.adminGet = async (req, res, next) => {
    const {yincana, estado, fechaIn, fechaFin}=req.body;
    try {
        let condicionesBusqueda=[{yincanaId: yincana}];
        if (estado!=='' && +estado<5)
        {
            condicionesBusqueda.push({estado: estado});
        } else {
            if(+estado === 100){
                condicionesBusqueda.push({ estado: {[Op.lt]: 4}});
            }else if (+estado === 12){
                condicionesBusqueda.push({[Op.or]: [{estado: 1},{estado: 2},{estado: 3}]});
            }
        }
        if(fechaIn!==''){
            condicionesBusqueda.push({solicitada: {[Op.gte]: fechaIn}});
        }
        if(fechaFin!==''){
            condicionesBusqueda.push({solicitada: {[Op.lte]: fechaFin}});
        }
        let findOptions={};
        findOptions.where = {[Op.and]: condicionesBusqueda}
        
        let inscripciones = await models.Inscripcion.findAll(findOptions);
        //console.log('+++++++++',JSON.stringify(condicionesBusqueda));
       //let yincanas = await models.Yincana.findAll();
        //console.log('+++++++++++++++++', JSON.stringify(yincanas))
        //res.render('admin', { yincanas });
        res.send(JSON.stringify(inscripciones));
    } catch (error) {
        console.log(error);
    }
};

exports.adminUpdate = async (req, res, next) => {
    let inscripciones=[];
    for (i in req.body){
        if(req.body[i][0]==='ESTADO'){
            if(!inscripciones[req.body[i][1]])inscripciones[req.body[i][1]]={};
            inscripciones[req.body[i][1]].estado = +req.body[i][2];
        }else if(req.body[i][0]==='NEQUIPO'){
            if(!inscripciones[req.body[i][1]])inscripciones[req.body[i][1]]={};
            inscripciones[req.body[i][1]].nequipo= +req.body[i][2];
        }
    }
    
    const t = await sequelize.transaction();
    try{
    let actualizamos=[];
    for (j=0;j<inscripciones.length;j++){
    //inscripciones.forEach(async (item, j) =>{
        //if(item){
          if(inscripciones[j]){
            
                let inscrip = await models.Inscripcion.findByPk(j);
                let his_inscripcion = models.His_inscripcion.build({
                    hid: inscrip.id,
                    yincanaId: inscrip.yincanaId,
                    nequipo: inscrip.nequipo,
                    nsol: inscrip.nsol,
                    clave: inscrip.clave,
                    encr: inscrip.encr,
                    valor: inscrip.valor,
                    solicitada: inscrip.solicitada,
                    recibida: inscrip.recibida,
                    estado: inscrip.estado,
                });
                //console.log('++++++',JSON.stringify(inscrip));
                //for (k in item){
                for (k in inscripciones[j]){
                    //inscrip[k]=item[k];
                    inscrip[k]=inscripciones[j][k]
                }
                if(!inscrip.recibida) inscrip.recibida=new Date();
                //inscrip =
                await his_inscripcion.save(); 
                await inscrip.save();
                //console.log('-------',JSON.stringify(inscrip));
                actualizamos.push(inscrip);
                //console.log('-------',JSON.stringify(actualizamos));
           
            //actualizamos+=j+', ';
        }
    //});
    }
    t.commit();
    //console.log('-------',JSON.stringify({inscripciones,actualizamos}));
    res.send(JSON.stringify(actualizamos));
    }catch(error){
        t.rollback();
        console.log(error);
    }
    
    /*try {
        let condicionesBusqueda=[{yincanaId: yincana}];
        if (estado!=='' && +estado<5)
        {
            condicionesBusqueda.push({estado: estado});
        } else {
            if(+estado === 100){
                condicionesBusqueda.push({ estado: {[Op.lt]: 4}});
            }else if (+estado === 12){
                condicionesBusqueda.push({[Op.or]: [{estado: 1},{estado: 2},{estado: 3}]});
            }
        }
        if(fechaIn!==''){
            condicionesBusqueda.push({solicitada: {[Op.gte]: fechaIn}});
        }
        if(fechaFin!==''){
            condicionesBusqueda.push({solicitada: {[Op.lte]: fechaFin}});
        }
        let findOptions={};
        findOptions.where = {[Op.and]: condicionesBusqueda}
        
        let inscripciones = await models.Inscripcion.findAll(findOptions);
        console.log('+++++++++',JSON.stringify(condicionesBusqueda));
       //let yincanas = await models.Yincana.findAll();
        //console.log('+++++++++++++++++', JSON.stringify(yincanas))
        //res.render('admin', { yincanas });
        res.send(JSON.stringify(inscripciones));
    } catch (error) {
        console.log(error);
    }*/
};

/*const paginate = require('../helpers/paginate').paginate;

// Autoload el quiz asociado a :quizId
exports.load = async (req, res, next, quizId) => {

    try {
        const quiz = await models.Quiz.findByPk(quizId);
        if (quiz) {
            req.load = {...req.load, quiz};
            next();
        } else {
            throw new Error('There is no quiz with id=' + quizId);
        }
    } catch (error) {
        next(error);
    }
};


// GET /quizzes
exports.index = async (req, res, next) => {

    let countOptions = {};
    let findOptions = {};

    // Search:
    const search = req.query.search || '';
    if (search) {
        const search_like = "%" + search.replace(/ +/g,"%") + "%";

        countOptions.where = {question: { [Op.like]: search_like }};
        findOptions.where = {question: { [Op.like]: search_like }};
    }

    try {
        const count = await models.Quiz.count(countOptions);

        // Pagination:

        const items_per_page = 10;

        // The page to show is given in the query
        const pageno = parseInt(req.query.pageno) || 1;

        // Create a String with the HTMl used to render the pagination buttons.
        // This String is added to a local variable of res, which is used into the application layout file.
        res.locals.paginate_control = paginate(count, items_per_page, pageno, req.url);

        findOptions.offset = items_per_page * (pageno - 1);
        findOptions.limit = items_per_page;

        const quizzes = await models.Quiz.findAll(findOptions);
        res.render('quizzes/index.ejs', {
            quizzes,
            search
        });
    } catch (error) {
        next(error);
    }
};


// GET /quizzes/:quizId
exports.show = (req, res, next) => {

    const {quiz} = req.load;

    res.render('quizzes/show', {quiz});
};


// GET /quizzes/new
exports.new = (req, res, next) => {

    const quiz = {
        question: "",
        answer: ""
    };

    res.render('quizzes/new', {quiz});
};

// POST /quizzes/create
exports.create = async (req, res, next) => {

    const {question, answer} = req.body;

    let quiz = models.Quiz.build({
        question,
        answer
    });

    try {
        // Saves only the fields question and answer into the DDBB
        quiz = await quiz.save({fields: ["question", "answer"]});
        req.flash('success', 'Quiz created successfully.');
        res.redirect('/quizzes/' + quiz.id);
    } catch (error) {
        if (error instanceof Sequelize.ValidationError) {
            req.flash('error', 'There are errors in the form:');
            error.errors.forEach(({message}) => req.flash('error', message));
            res.render('quizzes/new', {quiz});
        } else {
            req.flash('error', 'Error creating a new Quiz: ' + error.message);
            next(error);
        }
    }
};


// GET /quizzes/:quizId/edit
exports.edit = (req, res, next) => {

    const {quiz} = req.load;

    res.render('quizzes/edit', {quiz});
};


// PUT /quizzes/:quizId
exports.update = async (req, res, next) => {

    const {body} = req;
    const {quiz} = req.load;

    quiz.question = body.question;
    quiz.answer = body.answer;

    try {
        await quiz.save({fields: ["question", "answer"]});
        req.flash('success', 'Quiz edited successfully.');
        res.redirect('/quizzes/' + quiz.id);
    } catch (error) {
        if (error instanceof Sequelize.ValidationError) {
            req.flash('error', 'There are errors in the form:');
            error.errors.forEach(({message}) => req.flash('error', message));
            res.render('quizzes/edit', {quiz});
        } else {
            req.flash('error', 'Error editing the Quiz: ' + error.message);
            next(error);
        }
    }
};


// DELETE /quizzes/:quizId
exports.destroy = async (req, res, next) => {

    try {
        await req.load.quiz.destroy();
        req.flash('success', 'Quiz deleted successfully.');
        res.redirect('/goback');
    } catch (error) {
        req.flash('error', 'Error deleting the Quiz: ' + error.message);
        next(error);
    }
};


// GET /quizzes/:quizId/play
    exports.play = (req, res, next) => {

        const {query} = req;
        const {quiz} = req.load;

        const answer = query.answer || '';

        res.render('quizzes/play', {
            quiz,
            answer
        });
    };


// GET /quizzes/:quizId/check
    exports.check = (req, res, next) => {

        const {query} = req;
        const {quiz} = req.load;

        const answer = query.answer || "";
        const result = answer.toLowerCase().trim() === quiz.answer.toLowerCase().trim();

        res.render('quizzes/result', {
            quiz,
            result,
            answer
        });
    };

//GET /quizzes/randomplay

exports.randomPlay =  async (req, res, next) => {

    try {
        let score=0;
        let orden=[];//contendra el array con el orden al azar en que se formularán
        let quizzes;
        let noRecargaCheck=true;
        if(req.session.score===undefined){//preparamos la tanda de preguntas desordenadas
            const count = await models.Quiz.count();
            quizzes = await models.Quiz.findAll();//todas las preguntas
            for (let i=0;i<count;i++)orden.push(i);
            for (let i=0;i<count;i++){
                let pos=Math.floor(count*Math.random());
                let aux=orden[i];
                orden[i]=orden[pos];
                orden[pos]=aux;
            }
            req.session.score=0
            req.session.orden=orden;//el orden al azar en que se preguntarán
            req.session.quizzes=quizzes;
        }else{
            orden = req.session.orden;
            quizzes = req.session.quizzes;
           
        }
        score = req.session.score;
        req.session.noRecargaCheck=noRecargaCheck;//para evitar que aumente el score si se recarga el resultado; 
        
        let quiz=quizzes[orden[score]];//tomamos el que corresponde a partir del array de orden al azar
        
        if (score===orden.length){//no more quiz
            delete req.session.score; 
            res.render('quizzes/random_nomore', {
                score
            });
        } else{
            res.render('quizzes/random_play', {
                quiz,
                score
            });
        }
    } catch (error) {
        next(error);
    }
    
};

    //GET /quizzes/randomcheck/:quizId
    exports.randomCheck = (req, res, next) => {

        const {query} = req;
        const {quiz} = req.load;

        const answer = query.answer || "";
        const result = answer.toLowerCase().trim() === quiz.answer.toLowerCase().trim();
        
        let score;
        if (result){
            if(req.session.noRecargaCheck) score=++req.session.score;
            else score=req.session.score;//no se incrementa si se ha recargado
        }else{
            score=req.session.score;
            delete req.session.score; 
        }
        req.session.noRecargaCheck=false; //para que no se aumente el escore si se recarga esta url
        
            res.render('quizzes/random_result', {
                quiz,
                result,
                answer,
                score
            });
        
    };*/
