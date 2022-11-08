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
     return queryInterface.bulkInsert('inscripciones', [
        {
            yincanaId: 1,
            //nequipo: 1,
            nsol:10001,
            clave: '272279',
            encr: 'rxHUInQTXnx0hH4hEs9TjjxXOjTm2QHwmhtujzDtmeUVIwXa',
            valor:'rxHUInQTXnx0hH4hEs9TjjxXOjTm2QHwmhtujzDtmeUVIwXa/tXRL6sEReKicqeV8Q5mkXpTCFUROmHwrXXfMBYSTqiDN07ZsAVxxo/23zXccPS/32C0X7cLf27LrEneP2FXfs36c0xnJpMMk/e+r+mLtvC9rYw4Xrcxj3tMkHBXQ63xBQqknb4+gLMrupyLOV4jL3cEb4P9/sZSPvzy5PNxoUp9nAbWbZWjzAkBQCweMrYKCtqWIyuFw9I570ao00dPaNPTL48zF97MsUH7kIkO8FASaT/xAkdi1kyZrg82i38Fq6eTvJweVXggM0K95uEHDpEwZIEwObHbhi2JzIIOG5ePHYKxMnjbSFlzKnu78zFgW/0YdGYRN5dZL2zJ1i7pl2dU5Z+WmmPef4w7teDMvbsLHvcCGymtBBignzM9znJwTusJxyfgniB3PbjMmUlay7MWFt2VmCDH0HIsjgxMLgY6ghO1cOLbMq8tTbOesRoqQHkdNXxNZROZVzrjACtfE3CXijmPGDc/gK+Ak3YwljNTGGDO5CATE3E0GOe42uJLrI7HVxlseg+m/xk3S/Ft+qc30zlE+oPBObzS3o2gb0Po6XzGPpMGWqqHbc1tCYHZIzf0bJkugUYZSsYKWCYadHpgKuUCBxxWsv1GQqrUxtxNyacWa652Wnjv4kQ=',
            solicitada:new Date(),
            //recibida:,
            estado:0,
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
     return queryInterface.dropTable('Inscripciones');
  }
};
