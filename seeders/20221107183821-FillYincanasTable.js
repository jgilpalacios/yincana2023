'use strict';

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(queryInterface, Sequelize) {
    /**
     * Add seed commands here.
     *
     * Example:
     * await queryInterface.bulkInsert('People', [{
     *   name: 'John Doe',
     *   isBetaMember: false
     * }], {});
    */
    return queryInterface.bulkInsert('Yincanas', [
      {
        nsol: 1001,
        utilidad: 'BOADILLA DEL MONTE',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        nsol: 2001,
        utilidad: 'COLLADO VILLALBA',
        createdAt: new Date(),
        updatedAt: new Date()
      },
    ]);
  },

  async down(queryInterface, Sequelize) {
    /**
     * Add commands to revert seed here.
     *
     * Example:
     * await queryInterface.bulkDelete('People', null, {});
     */
    return queryInterface.bulkDelete('Yincanas', null, {});
  }
};
