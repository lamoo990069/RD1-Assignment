const express = require('express');
const app = express();

const request = require('request');

const bodyParser = require('body-parser');
app.use( bodyParser.json() );
app.use( bodyParser.urlencoded({extended: false}) );

app.use( express.static( "public" ) );

app.listen(80, () => {
    console.log(`Listening...`);
  });


// cross domain config
// app.all('/cwb', (req, res, next) => {
//     res.header("Access-Control-Allow-Origin", "*");
//     res.header("Access-Control-Allow-Headers", "X-Requested-With");
//     next();
// });

app.get('/cwb', (req, res) => {
    var url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-ED7050C5-A1A2-4409-B999-A4CCC6F4AFBB&elementName=T,MaxT,Wx,PoP12h';
    request(url, function (error, response, body) {
        if(!error && response.statusCode == 200) {
            res.send(JSON.parse(body))
            //console.log(JSON.parse(body));
        }
    });
});