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
        nsol: 1000,
        utilidad: 'BOADILLA DEL MONTE',
		clavePublica:`-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAu5AeYQ8ZtSQI8585cCQS
0Hh0WO6+Tj7lMcXqMsbegxOpd0VoR1m9pf9LnqfaaVwZ7C4xajGaMPZvPaUYCF2t
C5H8nlD3OtWhxlAGBevvc3+MfK7pwdzLK6DEItsslzBdbsY4cAsiNZ7n4hUOszrS
5rFRmTH7M13yfuSq6YYDinJuYNoCaXGGbAgBJ1mYLFMkMihb9Pl4ELzUoRCplBI/
DCoXgw1XMgNTwYWLuEyRZSLc890jr70Rk8LGCSbOZRoKdoZplEFt8FaWAw22d1PS
5dhUGVNlZkyQRwCiB9KSQ/4RDdW7Ssg/0Gn6ZOM68f30NVPKIvDjK1Cwce5LGwoY
VDVdDGP3q5SGcF+jxQheGBK+eDVzLCN4YxU6IxxdYEmyNCRQJfe8nDHAOo2tA6Ck
MF1ej7Nh0i7fsaCzrGcwfx7cTGxrlImMShA5Y1rae5b8axyB5iuXfO7UY3UKzAwo
jg/zTjcyHcERIBoiGIhOGCYjolLKC9Ok7uAKW3f7QPsylRyuL5AGvhDHyJ9SGd7O
KqR5d2OzQgXXa6w2NM3MUEK3BGAeE+DtMBF04q+bQQQk/YQcO9mzl3N95Nt3YU2b
TMpE9Z84beCfP+eES2BPNwimLGVXsgquer2UYhTdAiqSAKIJDkhiV+4SUdkRYb9P
FaCZRpJZCq06XEfuI5nYLekCAwEAAQ==
-----END PUBLIC KEY-----`,
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        nsol: 2000,
        utilidad: 'COLLADO VILLALBA',
		clavePublica:`-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA/MAp2PWGAove0BNm2caN
HHztSSQ7Shu+dSznTTmrFqdgk/2+XkRO169W1qvZfgByF+O8zbMNz9SQEgNmoj6h
/wRGNhdxk6BkqEqr+e6xtH6zyMkwb+hQMckXLwOzmozhH8XlGckpTwNri+QhhG+a
b4LesVvEZIzj9olp18ABJHTx0HtgObjF6Ti/aSiFewKh+2b+HEq3IOoRBtmmtsIl
5aRu5DbgH9IvphgZItybULC7Lc1md/GYpZx/7Pd6dvamjFe6Pc0okK5ZFR/2WzA4
MIgGXqevxz5cev54Qa+JhoLTP9Sv9Z3hiNOKDm6dEw911ZtaDGOALywl1R3nC8P/
4JTYeOHkY783S6KogGEbmbG+OVn3UDd6iqHSq9XXI3LE5MRbNWk83RPZC5+RQV9F
jSvlA+jJP8/12KLH8ZSChtW8nNwSAp8/zd89JMVKkrZwR/vstKIX2ijZMuiw15Kx
/omFk2LfbYSa/mlGvBhVmfmtOlvWQwqatdiDL1a5SEGg0PgadOv8w0fMvGTlwGeF
3kXnvEp2I1yZ3xdymJBpxibQ9X8rqw/q7iKGyR2O8YJzG1L9KXN2K3TWEClIKvnY
+JmjS8EvU2t+VnkIeCwZ2+lhW7oCU6HjnwkbHuYltr34jncNN1KxdmmQMS2ltN+H
TVueF21qaRCm5qZl9ImhY+ECAwEAAQ==
-----END PUBLIC KEY-----`,
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
