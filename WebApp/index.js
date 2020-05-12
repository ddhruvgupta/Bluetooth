// Lambda Function code for Alexa.
// Paste this into your index.js file. 

const Alexa = require("ask-sdk-core");
const https = require("https");
const request =  require("request");



const invocationName = "prof search";

// Session Attributes 
//   Alexa will track attributes for you, by default only during the lifespan of your session.
//   The history[] array will track previous request(s), used for contextual Help/Yes/No handling.
//   Set up DynamoDB persistence to have the skill save and reload these attributes between skill sessions.

function getMemoryAttributes() {   const memoryAttributes = {
 "history":[],

        // The remaining attributes will be useful after DynamoDB persistence is configured
        "launchCount":0,
        "lastUseTimestamp":0,

        "lastSpeechOutput":{},
        "nextIntent":[]

       // "favoriteColor":"",
       // "name":"",
       // "namePronounce":"",
       // "email":"",
       // "mobileNumber":"",
       // "city":"",
       // "state":"",
       // "postcode":"",
       // "birthday":"",
       // "bookmark":0,
       // "wishlist":[],
   };
   return memoryAttributes;
};

const maxHistorySize = 20; // remember only latest 20 intents 


// 1. Intent Handlers =============================================

const AMAZON_CancelIntent_Handler =  {
    canHandle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        return request.type === 'IntentRequest' && request.intent.name === 'AMAZON.CancelIntent' ;
    },
    handle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        const responseBuilder = handlerInput.responseBuilder;
        let sessionAttributes = handlerInput.attributesManager.getSessionAttributes();


        let say = 'Okay, talk to you later! ';

        return responseBuilder
        .speak(say)
        .withShouldEndSession(true)
        .getResponse();
    },
};

const AMAZON_HelpIntent_Handler =  {
    canHandle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        return request.type === 'IntentRequest' && request.intent.name === 'AMAZON.HelpIntent' ;
    },
    handle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        const responseBuilder = handlerInput.responseBuilder;
        let sessionAttributes = handlerInput.attributesManager.getSessionAttributes();

        let intents = getCustomIntents();
        let sampleIntent = randomElement(intents);

        let say = 'You asked for help. '; 

        // let previousIntent = getPreviousIntent(sessionAttributes);
        // if (previousIntent && !handlerInput.requestEnvelope.session.new) {
        //     say += 'Your last intent was ' + previousIntent + '. ';
        // }
        // say +=  'I understand  ' + intents.length + ' intents, '

        say += ' Here something you can ask me, ' + getSampleUtterance(sampleIntent);

        return responseBuilder
        .speak(say)
        .reprompt('try again, ' + say)
        .getResponse();
    },
};

const AMAZON_StopIntent_Handler =  {
    canHandle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        return request.type === 'IntentRequest' && request.intent.name === 'AMAZON.StopIntent' ;
    },
    handle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        const responseBuilder = handlerInput.responseBuilder;
        let sessionAttributes = handlerInput.attributesManager.getSessionAttributes();


        let say = 'Okay, talk to you later! ';

        return responseBuilder
        .speak(say)
        .withShouldEndSession(true)
        .getResponse();
    },
};

const AMAZON_NavigateHomeIntent_Handler =  {
    canHandle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        return request.type === 'IntentRequest' && request.intent.name === 'AMAZON.NavigateHomeIntent' ;
    },
    handle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        const responseBuilder = handlerInput.responseBuilder;
        let sessionAttributes = handlerInput.attributesManager.getSessionAttributes();

        let say = 'Hello from AMAZON.NavigateHomeIntent. ';


        return responseBuilder
        .speak(say)
        .reprompt('try again, ' + say)
        .getResponse();
    },
};

const checkprof_Handler =  {
    canHandle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        return request.type === 'IntentRequest' && request.intent.name === 'checkprof' ;
    },
    async handle(handlerInput) {
        const request = handlerInput.requestEnvelope.request;
        const responseBuilder = handlerInput.responseBuilder;
        let sessionAttributes = handlerInput.attributesManager.getSessionAttributes();

        let say = 'Let me check. ';

        let slotStatus = '';
        let resolvedSlot;

        let slotValues = getSlotValues(request.intent.slots); 
        let response = "";


        // getSlotValues returns .heardAs, .resolved, and .isValidated for each slot, according to request slot status codes ER_SUCCESS_MATCH, ER_SUCCESS_NO_MATCH, or traditional simple request slot without resolutions

        // console.log('***** slotValues: ' +  JSON.stringify(slotValues, null, 2));
        //   SLOT: name 
        if (slotValues.name.heardAs) {
            // let myObject = await getValue(slotValues.name.heardAs, callback);

            let myObject = await httpGet(slotValues.name.heardAs);
            console.log(myObject);
            setTimeout(function() {}, 1000);

            slotStatus += ' The name was heard as ' + slotValues.name.heardAs + '. ';
            // slotStatus +=  slotValues.name.heardAs ;

        
            if (myObject.data[0].availability == 1){
                response += `Doctor ${myObject.data[0].fname} ${myObject.data[0].lname} is available`;
            }else{
                response += `Doctor ${myObject.data[0].fname} ${myObject.data[0].lname} is not available`;
            }
        


            
    } else {
        slotStatus += 'slot name is empty. ';
    }
    if (slotValues.name.ERstatus === 'ER_SUCCESS_MATCH') {
        slotStatus += 'a valid ';
        if(slotValues.name.resolved !== slotValues.name.heardAs) {
            slotStatus += 'synonym for ' + slotValues.name.resolved + '. '; 
        } else {
            slotStatus += 'match. ';
            } // else {
                //
            }
            if (slotValues.name.ERstatus === 'ER_SUCCESS_NO_MATCH') {
                slotStatus += 'which did not match any slot value. ';
                console.log('***** consider adding "' + slotValues.name.heardAs + '" to the custom slot type used by slot name! '); 
            }

            if( (slotValues.name.ERstatus === 'ER_SUCCESS_NO_MATCH') ||  (!slotValues.name.heardAs) ) {
                slotStatus += 'A few valid values are, ' + sayArray(getExampleSlotValues('checkprof','name'), 'or');
            }

            say += slotStatus;
            say += response;


            return responseBuilder
            .speak(say)
            .reprompt('try again, ' + say)
            .getResponse();
        },
    };

    const LaunchRequest_Handler =  {
        canHandle(handlerInput) {
            const request = handlerInput.requestEnvelope.request;
            return request.type === 'LaunchRequest';
        },
        handle(handlerInput) {
            const responseBuilder = handlerInput.responseBuilder;

            let say = 'hello' + ' and welcome to ' + invocationName + ' ! Which professors availability would you like to check ?';

            let skillTitle = capitalize(invocationName);


            return responseBuilder
            .speak(say)
            .reprompt('try again, ' + say)
            .withStandardCard('Welcome!', 
              'Hello!\nThis is a card for your skill, ' + skillTitle,
              welcomeCardImg.smallImageUrl, welcomeCardImg.largeImageUrl)
            .getResponse();
        },
    };

    const SessionEndedHandler =  {
        canHandle(handlerInput) {
            const request = handlerInput.requestEnvelope.request;
            return request.type === 'SessionEndedRequest';
        },
        handle(handlerInput) {
            console.log(`Session ended with reason: ${handlerInput.requestEnvelope.request.reason}`);
            return handlerInput.responseBuilder.getResponse();
        }
    };

    const ErrorHandler =  {
        canHandle() {
            return true;
        },
        handle(handlerInput, error) {
            const request = handlerInput.requestEnvelope.request;

            console.log(`Error handled: ${error.message}`);
        // console.log(`Original Request was: ${JSON.stringify(request, null, 2)}`);

        return handlerInput.responseBuilder
        .speak('Sorry, an error occurred.  Please say again.')
        .reprompt('Sorry, an error occurred.  Please say again.')
        .getResponse();
    }
};


// 2. Constants ===========================================================================

    // Here you can define static data, to be used elsewhere in your code.  For example: 
    //    const myString = "Hello World";
    //    const myArray  = [ "orange", "grape", "strawberry" ];
       // let myObject = {};

const APP_ID = undefined;  // TODO replace with your Skill ID (OPTIONAL).

// 3.  Helper Functions ===================================================================


function getValue(input){
    var request = require('request');
    var options = {
      'method': 'GET',
      'url': `http://bluetooth-env-test.eba-brqgvwur.us-east-2.elasticbeanstalk.com/WebApp/search.php?name=${input}`,
      'headers': {
      }
    };

    request(options, function (error, response) { 
      if (error) throw new Error(error);
      console.log(response.body);
      obj = JSON.parse(response.body)
      console.log(obj);
      return obj;
      

    });

}


function httpGet(input) {
  return new Promise(((resolve, reject) => {
   var request = require('request');
    
    var options = {
      'method': 'GET',
      'url': `http://bluetooth-env-test.eba-brqgvwur.us-east-2.elasticbeanstalk.com/WebApp/search.php?name=${input}`,
      'headers': {
      }
    };

    request(options, function (error, response) { 
      
      if (error) throw new Error(error);
      console.log(response.body);
      const obj = JSON.parse(response.body);
      console.log(obj);
      console.log(obj.data[0].fname)
      
      response.on('end', () => {
        resolve(obj);
      });

      response.on('error', (error) => {
        reject(error);
      });
      
    });
  }));
}

function capitalize(myString) {

   return myString.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); }) ;
}


function randomElement(myArray) { 
    return(myArray[Math.floor(Math.random() * myArray.length)]); 
} 

function stripSpeak(str) { 
    return(str.replace('<speak>', '').replace('</speak>', '')); 
} 




function getSlotValues(filledSlots) { 
    const slotValues = {}; 

    Object.keys(filledSlots).forEach((item) => { 
        const name  = filledSlots[item].name; 

        if (filledSlots[item] && 
            filledSlots[item].resolutions && 
            filledSlots[item].resolutions.resolutionsPerAuthority[0] && 
            filledSlots[item].resolutions.resolutionsPerAuthority[0].status && 
            filledSlots[item].resolutions.resolutionsPerAuthority[0].status.code) { 
            switch (filledSlots[item].resolutions.resolutionsPerAuthority[0].status.code) { 
                case 'ER_SUCCESS_MATCH': 
                slotValues[name] = { 
                    heardAs: filledSlots[item].value, 
                    resolved: filledSlots[item].resolutions.resolutionsPerAuthority[0].values[0].value.name, 
                    ERstatus: 'ER_SUCCESS_MATCH' 
                }; 
                break; 
                case 'ER_SUCCESS_NO_MATCH': 
                slotValues[name] = { 
                    heardAs: filledSlots[item].value, 
                    resolved: '', 
                    ERstatus: 'ER_SUCCESS_NO_MATCH' 
                }; 
                break; 
                default: 
                break; 
            } 
        } else { 
            slotValues[name] = { 
                heardAs: filledSlots[item].value, 
                resolved: '', 
                ERstatus: '' 
            }; 
        } 
    }, this); 

    return slotValues; 
} 

function getExampleSlotValues(intentName, slotName) { 

    let examples = []; 
    let slotType = ''; 
    let slotValuesFull = []; 

    let intents = model.interactionModel.languageModel.intents; 
    for (let i = 0; i < intents.length; i++) { 
        if (intents[i].name == intentName) { 
            let slots = intents[i].slots; 
            for (let j = 0; j < slots.length; j++) { 
                if (slots[j].name === slotName) { 
                    slotType = slots[j].type; 

                } 
            } 
        } 

    } 
    let types = model.interactionModel.languageModel.types; 
    for (let i = 0; i < types.length; i++) { 
        if (types[i].name === slotType) { 
            slotValuesFull = types[i].values; 
        } 
    } 


    examples.push(slotValuesFull[0].name.value); 
    examples.push(slotValuesFull[1].name.value); 
    if (slotValuesFull.length > 2) { 
        examples.push(slotValuesFull[2].name.value); 
    } 


    return examples; 
} 

function sayArray(myData, penultimateWord = 'and') { 
    let result = ''; 

    myData.forEach(function(element, index, arr) { 

        if (index === 0) { 
            result = element; 
        } else if (index === myData.length - 1) { 
            result += ` ${penultimateWord} ${element}`; 
        } else { 
            result += `, ${element}`; 
        } 
    }); 
    return result; 
} 
function supportsDisplay(handlerInput) // returns true if the skill is running on a device with a display (Echo Show, Echo Spot, etc.) 
{                                      //  Enable your skill for display as shown here: https://alexa.design/enabledisplay 
    const hasDisplay = 
    handlerInput.requestEnvelope.context && 
    handlerInput.requestEnvelope.context.System && 
    handlerInput.requestEnvelope.context.System.device && 
    handlerInput.requestEnvelope.context.System.device.supportedInterfaces && 
    handlerInput.requestEnvelope.context.System.device.supportedInterfaces.Display; 

    return hasDisplay; 
} 


const welcomeCardImg = { 
    smallImageUrl: "https://s3.amazonaws.com/skill-images-789/cards/card_plane720_480.png", 
    largeImageUrl: "https://s3.amazonaws.com/skill-images-789/cards/card_plane1200_800.png" 


}; 

const DisplayImg1 = { 
    title: 'Jet Plane', 
    url: 'https://s3.amazonaws.com/skill-images-789/display/plane340_340.png' 
}; 
const DisplayImg2 = { 
    title: 'Starry Sky', 
    url: 'https://s3.amazonaws.com/skill-images-789/display/background1024_600.png' 

}; 

function getCustomIntents() { 
    const modelIntents = model.interactionModel.languageModel.intents; 

    let customIntents = []; 


    for (let i = 0; i < modelIntents.length; i++) { 

        if(modelIntents[i].name.substring(0,7) != "AMAZON." && modelIntents[i].name !== "LaunchRequest" ) { 
            customIntents.push(modelIntents[i]); 
        } 
    } 
    return customIntents; 
} 

function getSampleUtterance(intent) { 

    return randomElement(intent.samples); 

} 

function getPreviousIntent(attrs) { 

    if (attrs.history && attrs.history.length > 1) { 
        return attrs.history[attrs.history.length - 2].IntentRequest; 

    } else { 
        return false; 
    } 

} 

function getPreviousSpeechOutput(attrs) { 

    if (attrs.lastSpeechOutput && attrs.history.length > 1) { 
        return attrs.lastSpeechOutput; 

    } else { 
        return false; 
    } 

} 

function timeDelta(t1, t2) { 

    const dt1 = new Date(t1); 
    const dt2 = new Date(t2); 
    const timeSpanMS = dt2.getTime() - dt1.getTime(); 
    const span = { 
        "timeSpanMIN": Math.floor(timeSpanMS / (1000 * 60 )), 
        "timeSpanHR": Math.floor(timeSpanMS / (1000 * 60 * 60)), 
        "timeSpanDAY": Math.floor(timeSpanMS / (1000 * 60 * 60 * 24)), 
        "timeSpanDesc" : "" 
    }; 


    if (span.timeSpanHR < 2) { 
        span.timeSpanDesc = span.timeSpanMIN + " minutes"; 
    } else if (span.timeSpanDAY < 2) { 
        span.timeSpanDesc = span.timeSpanHR + " hours"; 
    } else { 
        span.timeSpanDesc = span.timeSpanDAY + " days"; 
    } 


    return span; 

} 


const InitMemoryAttributesInterceptor = { 
    process(handlerInput) { 
        let sessionAttributes = {}; 
        if(handlerInput.requestEnvelope.session['new']) { 

            sessionAttributes = handlerInput.attributesManager.getSessionAttributes(); 

            let memoryAttributes = getMemoryAttributes(); 

            if(Object.keys(sessionAttributes).length === 0) { 

                Object.keys(memoryAttributes).forEach(function(key) {  // initialize all attributes from global list 

                    sessionAttributes[key] = memoryAttributes[key]; 

                }); 

            } 
            handlerInput.attributesManager.setSessionAttributes(sessionAttributes); 


        } 
    } 
}; 

const RequestHistoryInterceptor = { 
    process(handlerInput) { 

        const thisRequest = handlerInput.requestEnvelope.request; 
        let sessionAttributes = handlerInput.attributesManager.getSessionAttributes(); 

        let history = sessionAttributes['history'] || []; 

        let IntentRequest = {}; 
        if (thisRequest.type === 'IntentRequest' ) { 

            let slots = []; 

            IntentRequest = { 
                'IntentRequest' : thisRequest.intent.name 
            }; 

            if (thisRequest.intent.slots) { 

                for (let slot in thisRequest.intent.slots) { 
                    let slotObj = {}; 
                    slotObj[slot] = thisRequest.intent.slots[slot].value; 
                    slots.push(slotObj); 
                } 

                IntentRequest = { 
                    'IntentRequest' : thisRequest.intent.name, 
                    'slots' : slots 
                }; 

            } 

        } else { 
            IntentRequest = {'IntentRequest' : thisRequest.type}; 
        } 
        if(history.length > maxHistorySize - 1) { 
            history.shift(); 
        } 
        history.push(IntentRequest); 

        handlerInput.attributesManager.setSessionAttributes(sessionAttributes); 

    } 

}; 




const RequestPersistenceInterceptor = { 
    process(handlerInput) { 

        if(handlerInput.requestEnvelope.session['new']) { 

            return new Promise((resolve, reject) => { 

                handlerInput.attributesManager.getPersistentAttributes() 

                .then((sessionAttributes) => { 
                    sessionAttributes = sessionAttributes || {}; 


                    sessionAttributes['launchCount'] += 1; 

                    handlerInput.attributesManager.setSessionAttributes(sessionAttributes); 

                    handlerInput.attributesManager.savePersistentAttributes() 
                    .then(() => { 
                        resolve(); 
                    }) 
                    .catch((err) => { 
                        reject(err); 
                    }); 
                }); 

            }); 

        } // end session['new'] 
    } 
}; 


const ResponseRecordSpeechOutputInterceptor = { 
    process(handlerInput, responseOutput) { 

        let sessionAttributes = handlerInput.attributesManager.getSessionAttributes(); 
        let lastSpeechOutput = { 
            "outputSpeech":responseOutput.outputSpeech.ssml, 
            "reprompt":responseOutput.reprompt.outputSpeech.ssml 
        }; 

        sessionAttributes['lastSpeechOutput'] = lastSpeechOutput; 

        handlerInput.attributesManager.setSessionAttributes(sessionAttributes); 

    } 
}; 

const ResponsePersistenceInterceptor = { 
    process(handlerInput, responseOutput) { 

        const ses = (typeof responseOutput.shouldEndSession == "undefined" ? true : responseOutput.shouldEndSession); 

        if(ses || handlerInput.requestEnvelope.request.type == 'SessionEndedRequest') { // skill was stopped or timed out 

            let sessionAttributes = handlerInput.attributesManager.getSessionAttributes(); 

            sessionAttributes['lastUseTimestamp'] = new Date(handlerInput.requestEnvelope.request.timestamp).getTime(); 

            handlerInput.attributesManager.setPersistentAttributes(sessionAttributes); 

            return new Promise((resolve, reject) => { 
                handlerInput.attributesManager.savePersistentAttributes() 
                .then(() => { 
                    resolve(); 
                }) 
                .catch((err) => { 
                    reject(err); 
                }); 

            }); 

        } 

    } 
}; 



// 4. Exports handler function and setup ===================================================
const skillBuilder = Alexa.SkillBuilders.custom();
exports.handler = skillBuilder
.addRequestHandlers(
    AMAZON_CancelIntent_Handler, 
    AMAZON_HelpIntent_Handler, 
    AMAZON_StopIntent_Handler, 
    AMAZON_NavigateHomeIntent_Handler, 
    checkprof_Handler, 
    LaunchRequest_Handler, 
    SessionEndedHandler
    )
.addErrorHandlers(ErrorHandler)
.addRequestInterceptors(InitMemoryAttributesInterceptor)
.addRequestInterceptors(RequestHistoryInterceptor)

   // .addResponseInterceptors(ResponseRecordSpeechOutputInterceptor)

 // .addRequestInterceptors(RequestPersistenceInterceptor)
 // .addResponseInterceptors(ResponsePersistenceInterceptor)

 // .withTableName("askMemorySkillTable")
 // .withAutoCreateTable(true)

 .lambda();


// End of Skill code -------------------------------------------------------------
// Static Language Model for reference

const model = {
  "interactionModel": {
    "languageModel": {
      "invocationName": "prof search",
      "intents": [
      {
          "name": "AMAZON.CancelIntent",
          "samples": []
      },
      {
          "name": "AMAZON.HelpIntent",
          "samples": []
      },
      {
          "name": "AMAZON.StopIntent",
          "samples": []
      },
      {
          "name": "AMAZON.NavigateHomeIntent",
          "samples": []
      },
      {
          "name": "checkprof",
          "slots": [
          {
              "name": "name",
              "type": "AMAZON.FirstName"
          }
          ],
          "samples": [
          "is doctor {name} in availble today",
          "is doctor {name} in the office",
          "is doctor {name} free",
          "is Professor {name} free",
          "is Dr. {name} available",
          "is Dr. {name} in the office"
          ]
      },
      {
          "name": "LaunchRequest"
      }
      ],
      "types": []
  }
}
};
