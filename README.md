# SURVEY module
a survey is build dynamically according to it's structure , it put's together different type of single dynForms to build a complete Survey we step through

- init module 
- show a dynForm  
- show a dynSurvey
- make login + create element 
- make login + create element + dynSurvey

# TODO 
[ ] logout redirects to CO2 and doesn't logout
[ ] design dynform
[ ] preview answers add validation button link to CTE, sans qu'il soit propriétaire links.projectExtern + orgaExtern
[ ] status :: Badge | status 
[rapha] systeme d'invitation  
[ ] make multi admins management
[ ] gestion des dates d'ouverture d'un sondage 
[ ] check json editor exists

# good to have 
[ ] afficher comme sondage dans une news 

#BUGS
- dynforms without images , go into the else condition of afterSave

# Features 
- [get a form json data](http://127.0.0.1/ph/survey/co/form/id/commons)
- [show a survey](http://127.0.0.1/ph/survey/co/index/id/commons)
- [show answers list](http://127.0.0.1/ph/survey/co/index/id/commons) 
- [show an answer](http://127.0.0.1/ph/survey/co/answer/id/5b1f7eba539f22636d952522)

## Problems to test
- for the moment cannot have multiple element creations in a survey because of images, it also means managing 2 instances of fileuploader in the same form session
    + a solution would be to have a separate form form any save Element part of a survey 

# console and development 
- a global object is used dySObj
- it contains dySObj.surveys.scenario which describe each step of a survey

# Algorythm

## definition
- in index build the presentation page based on dySObj.surveys.scenario
- a survey is build dynamically according to it's structure , it put's together different type of single dynForms to build a complete Survey we step through
- scenario steps can be :
    + existing dynForms (ex:organization)
    + dynForms described in the step (ex : partixxx)
    + a dynSurvey containing a list of dynforms (ex : survey containing steps : gouvernance, partage, partenaire)   

## building 
- dySObj.buildOneSurveyFromScenario 
    + $.each( dySObj.surveys.scenario
    + gathers all dynForm definitions according to types, can use ajax when in other modules with an asynchronous loading system
    + dySObj.surveys.json contains all steps and there dynForm definition
    + launching a form dySObj.openSurvey 
        * dySObj.buildSurveySections(); //prepares the sections format
        * dySObj.buildSurvey(); // builds the $.dynSurvey instance
            - builds the stepper wizard
            - contains the save process
- saveElement is managed onClick of the Next Btn, after dySObj.validateForm 

# Collections
- surveys are called forms, and defined by a json file containing dynform definitions, there are saved in collection "forms"
- answers are saved in the answers collection, if the corresponding form doesn't have a saveElement attribute 
- a form that has a saveElement, will save the element in it's own collection ex:organization 

# sample 
This survey contains 5 steps in it's scenario and 3 types of declarations
1 - organization 
    > uses and loads an existing dynForm 
    > "path" : "/js/dynForm/organization.js",
    > "where" : "parentModuleUrl", specifies that the definition is in the co2 module

```
{
    "_id" : ObjectId("5af5d2b5c17a01bbb8d47e48"),
    "id" : "commons",
    "title" : "What kind of common are you ?",
    "author" : "585bdfdaf6ca47b6118b4583",
    "description" : "What kind of common are youWhat kind of common are youWhat kind of common are youWhat kind of common are youWhat kind of common are youWhat kind of common are youWhat kind of common are youWhat kind of common are youWhat kind of common are youWhat",
    "parenType" : "organizations",
    "parentId" : "592e54d1539f2278258b456c",
    "surveyType" : "oneSurvey",
    "scenario" : {
        "organization" : {
            "title" : "Add an organization",
            "description" : "Add an organization Add an organization",
            "where" : "parentModuleUrl",
            "path" : "/js/dynForm/organization2.js",
            "type" : "script",
            "icon" : "fa-users",
            "saveElement" : {
                "collection" : "organizations",
                "ctrl" : "organization"
            }
        },
        "partixxxx" : {
            "title" : "partixxxx",
            "description" : "partenaires partenaires partenaires partenaires partenaires ",
            "icon" : "fa-users",
            "json" : {
                "jsonSchema" : {
                    "title" : "partixxxx",
                    "type" : "object",
                    "properties" : {
                        "separator1" : {
                            "title" : "Quelle manière le commun a t'il de nouer des partenariats avec des acteurs privés et publics ? Quelles approches utilisées ?"
                        },
                        "description" : {
                            "inputType" : "textarea",
                            "placeholder" : "Description",
                            "class" : "description3"
                        },
                        "value" : {
                            "inputType" : "select",
                            "placeholder" : "---- Select a value ----",
                            "options" : {
                                "0" : "Ne souhaite pas",
                                "20" : "Pas applicable",
                                "40" : "Souhait mais pas démarré",
                                "60" : "Démarré",
                                "80" : "En progression",
                                "100" : "Réalisé"
                            }
                        }
                    }
                }
            }
        },
        "survey" : {
            "title" : "What kind of common are you ?",
            "description" : "What kind of common are you  are you  are you  are you  are you  are you  are you  are you  ",
            "icon" : "fa-list-ul",
            "dynType" : "dynSurvey",
            "json" : {
                "partage" : {
                    "jsonSchema" : {
                        "title" : "Partage",
                        "type" : "object",
                        "properties" : {
                            "separator1" : {
                                "title" : " Quels sont les communs proches ou similaires ? Ont il été contactés pour essayer de mutualiser avec eux ? Comment le commun est travaillé pour favoriser sa réplication, sa diffusion ?"
                            },
                            "description" : {
                                "inputType" : "textarea",
                                "placeholder" : "Description",
                                "class" : "description1"
                            },
                            "value" : {
                                "inputType" : "select",
                                "placeholder" : "---- Select a value ----",
                                "options" : {
                                    "0" : "Ne souhaite pas",
                                    "20" : "Pas applicable",
                                    "40" : "Souhait mais pas démarré",
                                    "60" : "Démarré",
                                    "80" : "En progression",
                                    "100" : "Réalisé"
                                }
                            }
                        }
                    }
                },
                "gouvernance" : {
                    "jsonSchema" : {
                        "title" : "Gouvernance",
                        "type" : "object",
                        "properties" : {
                            "separator1" : {
                                "title" : "Comment est pensée la gouvernance pour permettre à tous de s'approprier le commun sans pour autant réduire l'initiative individuelle ?"
                            },
                            "description" : {
                                "inputType" : "textarea",
                                "placeholder" : "Description",
                                "class" : "description2"
                            },
                            "value" : {
                                "inputType" : "select",
                                "placeholder" : "---- Select a value ----",
                                "options" : {
                                    "0" : "Ne souhaite pas",
                                    "20" : "Pas applicable",
                                    "40" : "Souhait mais pas démarré",
                                    "60" : "Démarré",
                                    "80" : "En progression",
                                    "100" : "Réalisé"
                                }
                            }
                        }
                    }
                },
                "partenaires" : {
                    "jsonSchema" : {
                        "title" : "Partenaires",
                        "type" : "object",
                        "properties" : {
                            "separator1" : {
                                "title" : "Quelle manière le commun a t'il de nouer des partenariats avec des acteurs privés et publics ? Quelles approches utilisées ?"
                            },
                            "description" : {
                                "inputType" : "textarea",
                                "placeholder" : "Description",
                                "class" : "description3"
                            },
                            "value" : {
                                "inputType" : "select",
                                "placeholder" : "---- Select a value ----",
                                "options" : {
                                    "0" : "Ne souhaite pas",
                                    "20" : "Pas applicable",
                                    "40" : "Souhait mais pas démarré",
                                    "60" : "Démarré",
                                    "80" : "En progression",
                                    "100" : "Réalisé"
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
```

# wishlist 
- url to open a survey directly , without the presentation steps
- build dynForms onDemand, on click next > builds the form, instead ahead. This will repair the problem of not being able to have many dynForm elements it will also repair the pb of having one single form, might create problems with next and prev though 
- simple form register page 
- tree like navigation, certain steps could switch surveys
    + if answer this then survey1 else survey2
- ponderation et gamification des reponses, ca peut aussi etre un process post process , mais ca peut etre sympas de d'afficher un score au fur et à mesure qu'on rempli une liste de QCM , ex : le question des communes , avec les 15 questions de la transition citoyenne., etes vous une commune en transition.
- idée de questionnaire : 
    + imaginer un survey what kind of citizen am I ?
    + faire le survey du temps citoyen
    + label tiers lieux https://github.com/nicolasloubet/Label-tiers-lieux
- integrate an option to use https://enketo.org/about/#enketo-features
