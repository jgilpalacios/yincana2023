//para gestionar transacciones como indica en 
//https://www.ultimateakash.com/blog-details/IiwzPGAKYAo=/How-to-implement-Transactions-in-Sequelize-&-Node.Js-(Express)
const Sequelize = require('sequelize'); 
const conn = {};
const path = require('path');
const url = process.env.DATABASE_URL || "sqlite:yincana2023.sqlite";
// Load ORM
//const Sequelize= require('sequelize');
//const {Sequelize, Model, DataTypes } = require('sequelize');


// Environment variable to define the URL of the data base to use.
// To use SQLite data base:
//    DATABASE_URL = sqlite:yincana2023.sqlite
// To use  Heroku Postgres data base:
//    DATABASE_URL = postgres://user:passwd@host:port/database



const sequelize = new Sequelize(url);

//en original para mysql
/*const sequelize = new Sequelize('my_db', 'username', 'password', {
    host: 'localhost',
    dialect: 'mysql',
    operatorsAliases: 'false',
    logging: false
});*/

conn.sequelize = sequelize;
conn.Sequelize = Sequelize;

module.exports = conn;