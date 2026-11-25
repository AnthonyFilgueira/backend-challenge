import {app} from './app.js';import {env} from './config/env.js';app.listen({host:'0.0.0.0',port:env.PORT}).catch(err=>{app.log.error(err);process.exit(1);});
