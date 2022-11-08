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
      'Yincanas',
        {
          id: {
            type: Sequelize.INTEGER,
            allowNull: false,
            primaryKey: true,
            autoIncrement: true,
            unique: true
          },
          nsol: {
            type: Sequelize.INTEGER,
            validate: {notEmpty: {msg: "El numero de solicitud de la yincana no debe faltar"}}
          },
          utilidad: {
            type: Sequelize.STRING,
            validate: {notEmpty: {msg: "La localidad de la yincana no debe faltar"}}
          },
          clavePublica: {
            type: Sequelize.STRING,
            validate: {notEmpty: {msg: "La clave pública de la yincana no debe faltar"}}
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
     return queryInterface.dropTable('Yincanas');
  }
};
