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
     return queryInterface.addColumn(
      'Inscripciones',
      'yincanaId',
      {
          type: Sequelize.INTEGER,
          references: {
              model: "Yincanas",
              key: "id"
          },
          onUpdate: 'CASCADE',
          onDelete: 'SET NULL'
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
     return queryInterface.removeColumn('Inscripciones', 'yincanaId');
  }
};
