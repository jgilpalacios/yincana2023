
const {Model} = require('sequelize');

// Definition of the Inscripcion model:

module.exports = (sequelize, DataTypes) => {

    class Inscripcion extends Model {}

    Inscripcion.init({
            yincanaId: {
            type: DataTypes.INTEGER,
            validate: {notEmpty: {msg: "yincanaId must not be empty"}}
            },
            nequipo: {
                type: DataTypes.INTEGER
            },
            nsol: {
                type: DataTypes.INTEGER,
                validate: {notEmpty: {msg: "num solicitud must not be empty"}}
                },
            clave: {
                type: DataTypes.STRING,
                validate: {notEmpty: {msg: "clave must not be empty"}}
            },
            encr: {
                type: DataTypes.STRING,
                validate: {notEmpty: {msg: "encr must not be empty"}}
            },
            valor: {
                type: DataTypes.STRING(50000),
                validate: {notEmpty: {msg: "valor must not be empty"}}
            },
            solicitada: {
                type: DataTypes.DATE,
                validate: {notEmpty: {msg: "solcitada date must not be empty"}}
            },
            recibida: {
                type: DataTypes.DATE
            },
            estado: {
                type: DataTypes.INTEGER,
                validate: {notEmpty: {msg: "estado not be empty"}}
            }
        }, {
            sequelize,
            tableName: 'Inscripciones' //para poder indicar el plural para nombre de tabla
        }
    );

    return Inscripcion;
};
