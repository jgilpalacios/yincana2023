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
      'His_inscripciones',
      'hid',
      {
          type: Sequelize.INTEGER,
          references: {
              model: "Inscripciones",
              key: "id"
          },
          onUpdate: 'CASCADE',
          onDelete: 'CASCADE'
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
     return queryInterface.removeColumn('His_inscripciones', 'hid');
  }
};
