const {Model} = require('sequelize');

// Definition of the Quiz model:

module.exports = (sequelize, DataTypes) => {

    class Rol extends Model {}

    Rol.init({
            nombre: {
                type: DataTypes.STRING,
                validate: {notEmpty: {msg: "El nombre del Rol no debe faltar"}}
            },
            clave: {
                type: DataTypes.STRING,
                validate: {notEmpty: {msg: "La clave del Rol no debe faltar"}}
            }
        }, {
            sequelize,
            tableName: 'Roles' //para poder indicar el plural para nombre de tabla

        }
    );

    return Rol;
};
