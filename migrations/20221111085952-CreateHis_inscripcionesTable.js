'use strict';

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up (queryInterface, Sequelize) {
    /**
     * Add altering commands here.
     *
     * Example:
     * await queryInterface.createTable('users', { id: Sequelize.INTEGER });
     */
     return queryInterface.createTable(
      'His_inscripciones',
        {
            id: {
                type: Sequelize.INTEGER,
                allowNull: false,
                primaryKey: true,
                autoIncrement: true,
                unique: true
            },
            /*hid: {
              type: Sequelize.INTEGER,
              validate: {notEmpty: {msg: "yincanaId must not be empty"}}

            },*/
              yincanaId: {
              type: Sequelize.INTEGER,
              validate: {notEmpty: {msg: "yincanaId must not be empty"}}
              },
              nequipo: {
                  type: Sequelize.INTEGER
              },
              nsol: {
                  type: Sequelize.INTEGER,
                  validate: {notEmpty: {msg: "num solicitud must not be empty"}}
                  },
              clave: {
                  type: Sequelize.STRING,
                  validate: {notEmpty: {msg: "clave must not be empty"}}
              },
              encr: {
                  type: Sequelize.STRING,
                  validate: {notEmpty: {msg: "encr must not be empty"}}
              },
              valor: {
                  type: Sequelize.STRING(50000),
                  validate: {notEmpty: {msg: "valor must not be empty"}}
              },
              solicitada: {
                  type: Sequelize.DATE,
                  validate: {notEmpty: {msg: "solcitada date must not be empty"}}
              },
              recibida: {
                  type: Sequelize.DATE
              },
              estado: {
                  type: Sequelize.INTEGER,
                  validate: {notEmpty: {msg: "estado not be empty"}}
              },
            
            createdAt: {
                type: Sequelize.DATE,
                allowNull: false
            },
            updatedAt: {
                type: Sequelize.DATE,
                allowNull: false
            }
        },
        {
            sync: {force: true}
        }
      );
  },

  async down (queryInterface, Sequelize) {
    /**
     * Add reverting commands here.
     *
     * Example:
     * await queryInterface.dropTable('users');
     */
     return queryInterface.dropTable('His_inscripciones');
  }
};
