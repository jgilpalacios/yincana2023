
const {Model} = require('sequelize');

// Definition of the Quiz model:

module.exports = (sequelize, DataTypes) => {

    class Yincana extends Model {}

    Yincana.init({
            nsol: {
                type: DataTypes.INTEGER,
                validate: {notEmpty: {msg: "El numero de solicitud de la yincana no debe faltar"}}
            },
            utilidad: {
                type: DataTypes.STRING,
                validate: {notEmpty: {msg: "La localidad de la yincana no debe faltar"}}
            },
            clavePublica: {
                type: DataTypes.STRING(5000),
                validate: {notEmpty: {msg: "La clave pública de la yincana no debe faltar"}}
            }
        }, {
            sequelize
        }
    );

    return Yincana;
};
