// This tool routes in three steps
// intended to be used (at least) as an exposed docker container
const express = require('express')
const rp = require('request-promise');
const app = express();
const fs = require("fs")
const getUrlParam = require("./getUrlParam")

app.use(express.json());


// Sessions
// CACHE Resolvers
// CACHE Keys, put in session

// User/security routes

// resolve using routes.json


app.use("/", async function(req, res){
  let type = req.originalUrl.split("/")[1]
  let path = req.originalUrl.split("/").slice(2).join("/");
  let auth = req.headers.authorization;
  // check auth
  var is_authorized
  try{
    is_authorized = await checkAuth(type, path, auth, req)
  } catch(e){
    console.warn(e)
    res.status(500).send(decodeURIComponent(e))
  }
  // skip this check if told to
  if (!is_authorized) {
    return res.status(401).json({ error: 'Not Authorized' });
  }
  // route
  let url = await route(type, path, auth, req)
  options = {
    uri: url,
    encoding: null,
    method: req.method,
    resolveWithFullResponse: true
  }
  if (req.method != "GET"){
    options.body = req.body;
    options.json = true;
  }
  var resource = rp(options);
  resource.then(response=>{
    res.set(response.headers)
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    res.send(response.body)}
  );
  resource.catch(e=>{
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    res.status(500).send(e)
  })
})

app.listen(4010, () => console.log('listening on 4010'))
