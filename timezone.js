const { find } = require('geo-tz')
const latitude = parseFloat(process.argv[2]);
const longitude = parseFloat(process.argv[3]);
const timezone = find(latitude, longitude)[0];
console.log(timezone);