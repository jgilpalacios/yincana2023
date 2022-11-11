const path = require('path');

// Load ORM
const {Sequelize, DataTypes }= require('sequelize');
//const { Sequelize, Model, DataTypes } = require('sequelize');


// Environment variable to define the URL of the data base to use.
// To use SQLite data base:
//    DATABASE_URL = sqlite:yincana2023.sqlite
// To use  Heroku Postgres data base:
//    DATABASE_URL = postgres://user:passwd@host:port/database

const url = process.env.DATABASE_URL || "sqlite:yincana2023.sqlite";

const sequelize = new Sequelize(url);

// Import the definition of the Inscripcion Table from inscripcion.js
//const Inscripcion = sequelize.import(path.join(__dirname, 'inscripcion'));
const Inscripcion = require(path.join(__dirname, 'inscripcion'))(sequelize, DataTypes);

const Yincana = require(path.join(__dirname, 'yincana'))(sequelize, DataTypes);

const His_inscripcion = require(path.join(__dirname, 'his_inscripcion'))(sequelize, DataTypes);
// Relation 1-to-N between User and Quiz:
Yincana.hasMany(Inscripcion, { as: 'inscripciones', foreignKey: 'yincanaId' });
Inscripcion.belongsTo(Yincana, { as: 'localidad', foreignKey: 'yincanaId' });

Inscripcion.hasMany(His_inscripcion, { as: 'his_inscripciones', foreignKey: 'hid' });
His_inscripcion.belongsTo(Inscripcion, { as: 'identificador', foreignKey: 'hid' });

module.exports = sequelize;