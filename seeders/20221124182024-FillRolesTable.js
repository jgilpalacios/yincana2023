'use strict';

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up (queryInterface, Sequelize) {
    /**
     * Add seed commands here.
     *
     * Example:
     * await queryInterface.bulkInsert('People', [{
     *   name: 'John Doe',
     *   isBetaMember: false
     * }], {});
    */
     return queryInterface.bulkInsert('Roles', [
      {
        nombre: 'admin',
        clave: '21232f297a57a5a743894a0e4a801fc3',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        nombre: 'lector',
        clave: '21232f297a57a5a743894a0e4a801fc3',
        createdAt: new Date(),
        updatedAt: new Date()
      }
    ]);
  },

  async down (queryInterface, Sequelize) {
    /**
     * Add commands to revert seed here.
     *
     * Example:
     * await queryInterface.bulkDelete('People', null, {});
     */
     return queryInterface.bulkDelete('Roles', null, {});
  }
};
