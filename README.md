# SURVEY module
a survey is build dynamically according to it's structure , it put's together different type of single dynForms to build a complete Survey we step through

- init module 
- show a dynForm  
- show a dynSurvey
- make login + create element 
- make login + create element + dynSurvey

# TODO 
[ ] Section Admin
    - classification
    - structurant / fonctionnel 
    - set dates ( start end )
[ ] communauté : supprimer une invitation 
[ ] gestion des sessions
    nouvelle session 
    changer les dte start end 

#BUGS
- PB DE LOGIN : perte de session
    
# good to have 
[ ] session consultation : edit data 
[ ] reflechir survey juste avec email 
[ ] afficher comme sondage dans une news 
[ ] dynsurvey Editor 
    - first generate a dynform editor with CRUD features on dynform inputs
    - dynSurvey to edit a dynSurvey Generated 
    - generated based on dynForm schema properties 
[ ] integrated into DDA : DDDA Define :
[ ] check json editor exists

# Amélioration : 
- outil extract   ion des points clefs sur les dossier : highlither 
- creer un event , un atelier, 
    - invite 
    - validation de présence 
    - émargement   
- survey en full JS
- déposer juste avec un email 
- invité des collaborateur sur un dépot de dossier (avoir plusieurs admin d'un dossier ) user could be an array
- faire tourner le survey sur le server TCO
- générer un mode brouillon : un pad avec les questions 
- DOSSIER : save onBlur 
- avoir des admin liéé juste à un dossier et pas à toute la session 
- soumettre chaque risque à une vote des acteurs expert / financeurs ...
    comme une proposition , un risque peut etre levé 
    mais la communauté le vote et le pondère 

# Features 
- [get a form json data](http://127.0.0.1/ph/survey/co/form/id/commons)
- [show a survey](http://127.0.0.1/ph/survey/co/index/id/commons)
- [show answers list](http://127.0.0.1/ph/survey/co/index/id/commons) 
- [show an answer](http://127.0.0.1/ph/survey/co/answer/id/5b1f7eba539f22636d952522)

- A survey is a list of forms assembled together to obtain a set of answers.
- Answers can be made by users that can be invited 
- different types of users can be defined and invited to the survey process 
- As part of an administration process other users(admins) can comme add more answers, like moderation, or selection process answers which will complete the initial answers of the users 
- Géré les dates en fonction de chaque scénario, bloquer les action si date dépasser ou pas encore passé
- Unifier les answers en db en un seul doc 


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

# Reflexion
Key Partnerships
Key Activities
Key Resources
Value Propositions
Customer Relationships
Channels
Customer Segments
Cost Structure
Revenue Streams



HISTORIQUE AVANT QUE LES POI CHICHE VIENNE TOUT CASSER 

```
 
{
    "_id" : ObjectId("5b3c81e7af9c7748132938f0"),
    "id" : "cte2",
    "title" : "Le projet ?",
    "parentSurvey" : "cte",
    "author" : "5534fd9da1aa14201b0041cb",
    "description" : "La fiche projet sera celle visible sous réserve de son éligibilité.",
    "parentType" : "organizations",
    "parentId" : "5b47451ddd0452ca52000693",
    "surveyType" : "oneSurvey",
    "scenario" : {
        "project" : {
            "title" : "Ajouter votre projet",
            "description" : "Décrivez votre projet, sa localité, ses référents",
            "where" : "parentModuleUrl",
            "path" : "/js/dynForm/project2.js",
            "type" : "script",
            "icon" : "fa-lightbulb-o",
            "linkTo" : "cte1.organization",
            "saveElement" : {
                "collection" : "projects",
                "ctrl" : "project"
            }
        },
        "maturity" : {
            "title" : "Maturité",
            "description" : "Décrivez l'état du projet, son niveau d'avancement et les étapes clefs.",
            "icon" : "fa-clock-o",
            "json" : {
                "jsonSchema" : {
                    "title" : "Degré de maturité",
                    "type" : "object",
                    "properties" : {
                        "separator1" : {
                            "inputType" : "custom",
                            "title" : "Quelle manière le commun a t'il de nouer des partenariats avec des acteurs privés et publics ? Quelles approches utilisées ?"
                        },
                        "state" : {
                            "inputType" : "select",
                            "placeholder" : "État du projet",
                            "options" : {
                                "idea" : "Idée ou Concept",
                                "CachierDesChargesDetaillé" : "cahier des charges detaillé",
                                "prototype" : "Prototype",
                                "developpement" : "En développement",
                                "test" : "En test",
                                "production" : "En production"
                            }
                        },
                        "description" : {
                            "inputType" : "textarea",
                            "placeholder" : "Décrivez l'état du projet, son degré de maturité et les étapes clefs.",
                            "class" : "description3 markdown"
                        },
                        "filterInfo" : {
                            "inputType" : "custom",
                            "html" : "<p class='item-comment bg-green-comment'>Veuillez saisir une date pour chacun des états de votre projet (Réaliser ou à venir).</p>"
                        },
                        "dateConcept" : {
                            "inputType" : "date",
                            "placeholder" : "Date de l'idée ou du concept",
                            "label" : "Date de l'idée ou du concept"
                        },
                        "dateCahier" : {
                            "inputType" : "date",
                            "placeholder" : "Date pour le cahier des charges detaillé",
                            "label" : "Date pour le cahier des charges detaillé"
                        },
                        "datePrototype" : {
                            "inputType" : "date",
                            "placeholder" : "Date de réalisation du prototype",
                            "label" : "Date de réalisation du prototype"
                        },
                        "dateDeveloppement" : {
                            "inputType" : "date",
                            "placeholder" : "Date de début de développement",
                            "label" : "Date de début de développement"
                        },
                        "dateTest" : {
                            "inputType" : "date",
                            "placeholder" : "Date des tests",
                            "label" : "Date des tests"
                        },
                        "dateProduction" : {
                            "inputType" : "date",
                            "placeholder" : "Date de mise en production",
                            "label" : "Date de mise en production"
                        }
                    }
                }
            }
        },
        "risk" : {
            "title" : "Gestion des risques",
            "description" : "Présentez les facteurs de risques.",
            "icon" : "fa-warning",
            "json" : {
                "jsonSchema" : {
                    "title" : "Décrivez les risques potentiels",
                    "type" : "object",
                    "properties" : {
                        "separator1" : {
                            "inputType" : "custom",
                            "title" : "Décrivez tous les types de risques : Financier, Juridique, Matériel, Technologique, ...etc"
                        },
                        "description" : {
                            "inputType" : "textarea",
                            "placeholder" : "Décrivez les risques potentiels et les parades (Management, Financier, Technique, Organisationnel, Sociaux, Environementaux, Ressources Humaines, Planification, Moyen, Démarche, Contractuel, Fonctionnel,...)",
                            "class" : "description3 markdown"
                        }
                    }
                }
            }
        }
    }
}

{
    "_id" : ObjectId("5b3c8189af9c7748132938ed"),
    "id" : "cte",
    "title" : "projets CTE",
    "author" : "5534fd9da1aa14201b0041cb",
    "custom" : {
        "header" : "survey.views.custom.cte",
        "footer" : "survey.views.custom.cteFooter",
        "logo" : "/images/custom/cte/logo-tco-cte.jpg",
        "endTpl" : "home",
        "color" : "#00B795",
        "roles" : [ 
            "Ville jardin désirable et support de biodiversité", 
            "Production renouvelable", 
            "Maîtrise de l’énergie", 
            "Eco-mobilités", 
            "Economie Sociale et solidaire", 
            "Economie circulaire et circuits courts"
        ],
        "tags" : [ 
            "Eco Quartier de la Possession", 
            "Plateforme de Transition Ecologique", 
            "Port Maritime Durable", 
            "Filière papier carton", 
            "Animation évaluation"
        ],
        "mail" : {
            "invitation" : {
                "msg" : "Bienvenue sur la plate-forme des projets du CTE"
            }
        }
    },
    "countryCode" : "RE",
    "description" : "Bienvenue sur la plate-forme des projets du CTE.<br/><br/> Différentes phases sont prévues dans le cadre de votre participation au Contrat de Transition Ecologique du TCO.<br/><br/> La première phase est celle du dépôt de votre projet. Chaque étape du formulaire est nécessaire pour prendre en compte de votre candidature.<br/><br/> Cette phase 1 vise à recenser les projets voulant s’inscriredans la transition écologique du territoire Ouest de La Réunion. <br/><br/>La phase suivant celle du dépôt des projets est la phase d'évaluation et de présélection des projets qui participeront à la phase finale, celle de l’élection des projets qui bénéficieront de l'aide du Contrat de Transition Ecologique du TCO.",
    "parentType" : "organizations",
    "parentId" : "5b47451ddd0452ca52000693",
    "surveyType" : "surveyList",
    "scenario" : {
        "cte1" : {
            "title" : "Porteur du projet",
            "description" : "Référencer le porteur du projet ainsi qu'un référent au sein de la structure",
            "icon" : "fa-users"
        },
        "cte2" : {
            "title" : "Fiche du projet",
            "description" : "La fiche qui sera mise en ligne lors de l'ouverture au vote",
            "icon" : "fa-lightbulb-o"
        },
        "cte3" : {
            "title" : "Dépot de l'action",
            "description" : "Objectif et prévisionnel de l'action dans le cadre du CTE",
            "icon" : "fa-list"
        }
    },
    "updated" : NumberLong(1531826331),
    "modified" : ISODate("2018-07-17T11:18:51.000Z")
}

{
    "_id" : ObjectId("5b3c8194af9c7748132938ee"),
    "id" : "cte1",
    "parentSurvey" : "cte",
    "title" : "Porteur du Projet ?",
    "author" : "5534fd9da1aa14201b0041cb",
    "description" : "<span class='text-red'><i class='fa fa-check-square-o fa-2x' style='vertical-align:middle'></i> En candidatant vous acceptez les conditions de <a class='text-red openFile' href='javascript:;' data-file='/images/custom/cte/Charte d’utilisation de l’espace dédié au CTE-TCO sur le site web communecter.pdf' ><u>la charte du CTE TCO</u></a></span> <br/><br/> Le porteur du projet et de l'action est la structure qui garantie la prise en charge de l'action d'un point de vue juridique mais aussi organisationnel.<br/><br/>Un référent devra etre cité pour priviligier une point de contact facile",
    "parentType" : "organizations",
    "parentId" : "5b47451ddd0452ca52000693",
    "surveyType" : "oneSurvey",
    "scenario" : {
        "organization" : {
            "title" : "Ajouter une structure porteuse",
            "description" : "Présenter l'organisation porteuse du projet.",
            "where" : "parentModuleUrl",
            "path" : "/js/dynForm/organization2.js",
            "type" : "script",
            "icon" : "fa-users",
            "saveElement" : {
                "collection" : "organizations",
                "ctrl" : "organization"
            }
        },
        "justificatif" : {
            "title" : "Justificatifs et référent",
            "description" : "Jusitifiez de la légalité de votre structure et éligez un référent",
            "icon" : "fa-user-card",
            "json" : {
                "jsonSchema" : {
                    "title" : "Justificatifs et référent",
                    "type" : "object",
                    "properties" : {
                        "status" : {
                            "inputType" : "uploader",
                            "label" : "Ajouter les statuts ou Kbis ou Délibération :",
                            "showUploadBtn" : false,
                            "docType" : "file",
                            "itemLimit" : 1,
                            "contentKey" : "survey",
                            "domElement" : "statusFile",
                            "placeholder" : "Statuts de la structure",
                            "linkTo" : "organization",
                            "endPoint" : "/subDir/survey.cte1.status/surveyId/cte",
                            "afterUploadComplete" : "/survey/co/index/id/cte2",
                            "template" : "qq-template-manual-trigger",
                            "filetypes" : [ 
                                "pdf"
                            ]
                        },
                        "nameRefence" : {
                            "inputType" : "text",
                            "label" : "Nom du référent",
                            "placeholder" : "Nom du reférent"
                        },
                        "mailRefence" : {
                            "inputType" : "text",
                            "label" : "Email du référent-e",
                            "placeholder" : "exemple@mail.com",
                            "rules" : {
                                "email" : true
                            }
                        }
                    }
                }
            }
        }
    }
}

{
    "_id" : ObjectId("5b3c81daaf9c7748132938ef"),
    "id" : "cte3",
    "parentSurvey" : "cte",
    "title" : "Objectifs ?",
    "author" : "5534fd9da1aa14201b0041cb",
    "description" : "Définissez l'action dans le cadre du contrat de transition Ecologique",
    "parentType" : "organizations",
    "parentId" : "5b47451ddd0452ca52000693",
    "surveyType" : "oneSurvey",
    "scenario" : {
        "objectif" : {
            "title" : "Objectif et enjeux de l'initiative",
            "description" : "Présenter les objectifs intermédiaires du projet",
            "icon" : "fa-arrow-circle-up",
            "json" : {
                "jsonSchema" : {
                    "title" : "Objectif du projet",
                    "type" : "object",
                    "properties" : {
                        "objectif" : {
                            "inputType" : "textarea",
                            "label" : "Objectifs de l'initiative",
                            "placeholder" : "Décrire les objectifs, les finalités et les usages de l’initiative et les impacts qui en découleront (sur le territoire, sur les personnes, sur les structures, sur le collectif, etc.).",
                            "class" : "description3 markdown"
                        },
                        "description" : {
                            "inputType" : "textarea",
                            "label" : "Description de l’initiative et des activités développées",
                            "placeholder" : "Actions prévues, architecture de l’opération (déroulé, étape, moyens humains et techniques, etc.)",
                            "class" : "description3 markdown"
                        },
                        "usagers" : {
                            "inputType" : "textarea",
                            "label" : "Cibles, Usagers ou Bénéficiaires*",
                            "placeholder" : "A qui s’adresse l’initiative, quels sont les cibles, les usagers et / ou les bénéficiaires ? Quel(s) bénéfice(s) pour les usagers ?",
                            "class" : "description3 markdown"
                        },
                        "cooperateurs" : {
                            "inputType" : "textarea",
                            "label" : "Présentation des coopérateurs",
                            "placeholder" : "Décrire l’ensemble des coopérateurs en précisant leur degré d’implication ? Comment interviennent-ils ? Quel est leur rôle, leur implication, leur participation, leur intérêt dans l’initiative ?",
                            "class" : "description3 markdown"
                        },
                        "impact" : {
                            "inputType" : "select",
                            "placeholder" : "Zone d'impact",
                            "options" : {
                                "local" : "Local",
                                "regional" : "Regional",
                                "national" : "National",
                                "international" : "International"
                            }
                        },
                        "territoire" : {
                            "inputType" : "textarea",
                            "label" : "Territoire impacté",
                            "placeholder" : "Décrire le territoire de l’action et préciser quelle est l’influence du territoire sur l’initiative ? Le projet s’appuie-t-il sur des ressources du territoire ? Les acteurs du projet, partenaires, fournisseurs sont-ils issus du territoire ? Comment sont-ils impliqués dans l’action ?",
                            "class" : "description3 markdown"
                        },
                        "gouvernance" : {
                            "inputType" : "textarea",
                            "label" : "Gouvernance de l'initiative",
                            "placeholder" : "Décrire comment est construite l’initiative avec ses membres, partenaires et usagers. Présenter les modes de prises des décisions de l’initiative (comité de pilotage, espace d’expression et de débat, etc.). De quelles manières sont prises les décisions entre coopérateurs ? Quel est le niveau d’implication de chacun des coopérateurs dans la gouvernance ?",
                            "class" : "description3 markdown"
                        }
                    }
                }
            }
        },
        "previsionnel" : {
            "title" : "Prévisionnel",
            "description" : "Décrivez les ressources, les besoins et le plan prévisionnel",
            "icon" : "fa-bar-chart",
            "json" : {
                "jsonSchema" : {
                    "title" : "Financement prévisionnel",
                    "type" : "object",
                    "properties" : {
                        "ressources" : {
                            "inputType" : "textarea",
                            "label" : "Ressources",
                            "placeholder" : "Décrire précisément l’ensemble des ressources mobilisées pour la mise en œuvre de l’action (financement public, activités marchandes, bénévolat, monnaie d’échange, fondations, etc.).",
                            "class" : "description3 markdown"
                        },
                        "besoins" : {
                            "inputType" : "textarea",
                            "label" : "Quels sont les besoins sur cette action ? En quoi le dispositif du CTE peut etre utile",
                            "placeholder" : "Actions prévues, architecture de l’opération (déroulé, étape, moyens humains et techniques, etc.)",
                            "class" : "description3 markdown"
                        },
                        "previsionel" : {
                            "inputType" : "uploader",
                            "afterUploadComplete" : "/survey/co/index/id/cte",
                            "label" : "Budget prévisionel:",
                            "showUploadBtn" : false,
                            "docType" : "file",
                            "itemLimit" : 1,
                            "linkTo" : "citoyens",
                            "contentKey" : "survey",
                            "placeholder" : "Budget prévisionel",
                            "domElement" : "previsionelFile",
                            "endPoint" : "/subDir/survey.cte3.previsionel/surveyId/cte",
                            "template" : "qq-template-manual-trigger",
                            "filetypes" : [ 
                                "pdf"
                            ]
                        }
                    }
                }
            }
        }
    }
}
{
    "_id" : ObjectId("5b3a2ed3b38e459e2b54cd12"),
    "id" : "cteAdmin",
    "parentSurvey" : "cteAdmin",
    "title" : "Priorisation",
    "key" : "priorisation",
    "author" : "5534fd9da1aa14201b0041cb",
    "description" : "MATRICE D'EVALUATION OPPORTUNITE MATRICE D'EVALUATION OPPORTUNITE MATRICE D'EVALUATION OPPORTUNITE MATRICE D'EVALUATION OPPORTUNITE MATRICE D'EVALUATION OPPORTUNITE MATRICE D'EVALUATION OPPORTUNITE MATRICE D'EVALUATION OPPORTUNITE MATRICE D'EVALUATION OPPORTUNITE MATRICE D'EVALUATION OPPORTUNITE MATRICE D'EVALUATION OPPORTUNITE ",
    "parentType" : "organizations",
    "parentId" : "5b47451ddd0452ca52000693",
    "surveyType" : "oneSurvey",
    "adminRole" : "TCO",
    "scenarioAdmin" : {
        "dossier" : {
            "title" : "Dossier",
            "icon" : "folder-open-o",
            "startDate" : ISODate("2018-06-10T12:01:14.000Z"),
            "endDate" : ISODate("2018-09-17T12:01:14.000Z")
        },
        "eligible" : {
            "title" : "Éligibilité <br/>par TCOPIL",
            "icon" : "thumbs-o-up",
            "startDate" : ISODate("2018-09-17T12:01:14.000Z"),
            "endDate" : ISODate("2018-09-17T12:01:14.000Z")
        },
        "priorisation" : {
            "title" : "Priorisation<br/> par TCOPIL",
            "icon" : "sort-amount-desc",
            "startDate" : ISODate("2018-09-17T12:01:14.000Z"),
            "endDate" : ISODate("2018-09-17T12:01:14.000Z"),
            "mail" : {
                "tpl" : "eligibilite",
                "tplObject" : "Etape de priorisation CTE",
                "messages" : "Votre projet est passé à l'étape de priorisation"
            }
        },
        "risk" : {
            "title" : "Gestion du Risque",
            "icon" : "warning",
            "startDate" : ISODate("2018-09-17T12:01:14.000Z"),
            "endDate" : ISODate("2018-09-17T12:01:14.000Z"),
            "mail" : {
                "tpl" : "eligibilite",
                "tplObject" : "Etape des contrainte du CTE",
                "messages" : "Votre projet est passé à l'étape des contraintes"
            }
        },
        "ficheAction" : {
            "title" : "Fiches Actions",
            "icon" : "file-text",
            "startDate" : ISODate("2018-09-17T12:01:14.000Z"),
            "endDate" : ISODate("2018-09-17T12:01:14.000Z"),
            "mail" : {
                "tpl" : "eligibilite",
                "tplObject" : "Etape de risque CTE",
                "messages" : "Votre projet est passé à l'étape d'etre ajouté à une fiche action"
            }
        }
    },
    "scenario" : {
        "opportunite" : {
            "title" : "MATRICE D'EVALUATION OPPORTUNITE",
            "description" : "critère d'évaluation d'opportunité",
            "icon" : "fa-clock-o",
            "json" : {
                "jsonSchema" : {
                    "title" : "MATRICE D'EVALUATION OPPORTUNITE",
                    "type" : "object",
                    "properties" : {
                        "prioPolitique" : {
                            "inputType" : "select",
                            "placeholder" : "Priorité Politique",
                            "weight" : "25","rules" : {
                                "required" : true
                            },
                            "options" : {
                                "1" : "Pas d'alignement stratégique",
                                "3" : "Rattachement à 1 opérationnel",
                                "5" : "Rattachement à plus d'un objectif opérationnel"
                            }
                        },
                        "maitriseRisque" : {
                            "inputType" : "select",
                            "placeholder" : "Maitrise des risques",
                            "weight" : "20","rules" : {
                                "required" : true
                            },
                            "options" : {
                                "1" : "Pas d'inventaire des risques",
                                "3" : "Risques identifiés Service pour l'usager",
                                "5" : "Risques identifiés et parades définies pour les contrer"
                            }
                        },
                        "beneficeUsager" : {
                            "inputType" : "select",
                            "placeholder" : "Bénéfice pour les usagers",
                            "weight" : "30","rules" : {
                                "required" : true
                            },
                            "options" : {
                                "1" : "Service pour les entreprises",
                                "3" : "Service pour l'usager",
                                "5" : "Service de droit commun "
                            }
                        },
                        "retourInvest" : {
                            "inputType" : "select",
                            "placeholder" : "Retour sur investissement",
                            "weight" : "25",
                            "rules" : {
                                "required" : true
                            },
                            "options" : {
                                "1" : "> 20 ans",
                                "3" : "Comprise entre 3 ans et 20 ans",
                                "5" : "< 3 ans"
                            }
                        },
                        "prioDesc" : {
                            "inputType" : "textarea",
                            "placeholder" : "Décrivez la raison du choix",
                            "class" : "description3 markdown"
                        }
                    }
                }
            }
        },
        "faisabilite" : {
            "title" : "MATRICE D'EVALUATION FAISABILITE",
            "description" : "critère d'évaluation de faisabilité",
            "icon" : "fa-thumbs-o-up",
            "json" : {
                "jsonSchema" : {
                    "title" : "MATRICE D'EVALUATION FAISABILITE",
                    "type" : "object",
                    "properties" : {
                        "calendrier" : {
                            "inputType" : "select",
                            "placeholder" : "Maîtrise du calendrier",
                            "weight" : "25",
                            "rules" : {
                                "required" : true
                            },
                            "options" : {
                                "1" : "Pas de planning",
                                "3" : "Planning partiellement défini",
                                "5" : "Planning maitrisé"
                            }
                        },
                        "maitriseRisque" : {
                            "inputType" : "select",
                            "weight" : "25",
                            "rules" : {
                                "required" : true
                            },
                            "placeholder" : "Capacité de mobilisation des acteurs",
                            "options" : {
                                "1" : "Acteurs non identifiés",
                                "3" : "Acteurs identifiés non disponibles",
                                "5" : "Acteurs identifiés et disponibles"
                            }
                        },
                        "finance" : {
                            "inputType" : "select",
                            "weight" : "25",
                            "rules" : {
                                "required" : true
                            },
                            "placeholder" : "Capacité financière",
                            "options" : {
                                "1" : "Capacité financière à 20%",
                                "3" : "Capacité financière à 60%",
                                "5" : "Capacité financière à 100%"
                            }
                        },
                        "retourInvest" : {
                            "inputType" : "select",
                            "weight" : "25",
                            "rules" : {
                                "required" : true
                            },
                            "placeholder" : "Capacité technique",
                            "options" : {
                                "1" : "Pas de processus",
                                "3" : "Processus non reproductible",
                                "5" : "Processus validé"
                            }
                        }
                    }
                }
            }
        }
    },
    "scenarioFicheAction" : {
        "ficheAction" : {
            "title" : "Fiche Action",
            "description" : "Formulaire d'une Fiche Action",
            "icon" : "cogs",
            "form" : {
                "scenario" : {
                    "projects" : {
                        "title" : "Projets",
                        "description" : "liste des projets associés à cette fiche action",
                        "arrayForm" : true,
                        "icon" : "fa-lightbulb-o",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Projets associés",
                                "icon" : "fa-lightbulb-o",
                                "properties" : {
                                    "projectsLinked" : {
                                        "inputType" : "arrayForm",
                                        "label" : "Liste des projets",
                                        "properties" : {
                                            "project" : {
                                                "placeholder" : "Projet"
                                            },
                                            "name" : {
                                                "placeholder" : "name"
                                            },
                                            "description" : {
                                                "placeholder" : "description"
                                            },
                                            "indicateur" : {
                                                "placeholder" : "indicateur",
                                                "class" : "description3 markdown"
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "detail" : {
                        "title" : "Détail",
                        "description" : "critère d'évaluation de faisabilité",
                        "icon" : "fa-info-circle",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Détail",
                                "type" : "object",
                                "properties" : {
                                    "startDate" : {
                                        "inputType" : "date",
                                        "label" : "Date de la demande",
                                        "placeholder" : "Date de la demande"
                                    },
                                    "partenaires" : {
                                        "inputType" : "text",
                                        "label" : "Partenaires",
                                        "placeholder" : "Quels sont les partenaires de cette fiche action ?"
                                    },
                                    "coherence" : {
                                        "inputType" : "textarea",
                                        "label" : "Analyse de cohérence",
                                        "placeholder" : "Eléments de justification de la cohérence du projet avec les orientations stratégiques du CTE TCO",
                                        "class" : "description3 markdown"
                                    }
                                }
                            }
                        }
                    },
                    "descriptif" : {
                        "title" : "Descriptif de l'action",
                        "description" : "Descriptif de l'action",
                        "icon" : "fa-info-circle",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Descriptif de l'action",
                                "type" : "object",
                                "properties" : {
                                    "importance" : {
                                        "inputType" : "textarea",
                                        "label" : "Indiquer les impacts attendus",
                                        "placeholder" : "Importance de l'action",
                                        "class" : "description3 markdown"
                                    },
                                    "objectifGeneral" : {
                                        "inputType" : "textarea",
                                        "label" : "Objectif général",
                                        "placeholder" : "Pour atteindre l'objectif général il faut plusieurs objectifs intermédiaires. C'est l'objectif stratégique.",
                                        "class" : "description3 markdown"
                                    },
                                    "objectifsIntermediaires" : {
                                        "inputType" : "textarea",
                                        "label" : "Objectifs intermédiaires et projets portés",
                                        "placeholder" : "Indiquez les projets à mener pour atteindre chaque objectif intermédiaire",
                                        "class" : "description3 markdown"
                                    },
                                    
                                    "evaluation" : {
                                        "inputType" : "textarea",
                                        "label" : "Evaluation de l'action",
                                        "placeholder" : "Définir la méthode d'évaluation de l'action. Indiquer le pilote de l'évaluation si différent du porteur",
                                        "class" : "description3 markdown"
                                    },
                                    "contraintes" : {
                                        "inputType" : "textarea",
                                        "label" : "Contraintes/ Risques (financiers - juridique/réglmentaire - RH - Technique)",
                                        "placeholder" : "Le cadre juridique, financier et technique dans le quel le projet devra se déployer",
                                        "class" : "description3 markdown"
                                    }
                                }
                            }
                        }
                    },
                    "results" : {
                        "title" : "Résultats attendus de l'action",
                        "description" : "Présenter 1 indicateur de résultat à minima et les sources de données",
                        "arrayForm" : true,
                        "icon" : "fa-calendar-check-o",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Résultats attendus de l'action",
                                "icon" : "fa-lightbulb-o",
                                "properties" : {
                                    "results" : {
                                        "inputType" : "arrayForm",
                                        "properties" : {
                                            "source" : {
                                                "inputType" : "textarea",
                                                "label" : "Indiquer les impacts attendus",
                                                "placeholder" : "Source et modalités de calcul"
                                            },
                                            "ref2018" : {
                                                "inputType" : "textarea",
                                                "label" : "Réf. 2018",
                                                "placeholder" : "Réf. 2018"
                                            },
                                            "res2019" : {
                                                "inputType" : "textarea",
                                                "label" : "Résultat 2019",
                                                "placeholder" : "Résultat 2019"
                                            },
                                            "res2020" : {
                                                "inputType" : "textarea",
                                                "label" : "Résultat 2020",
                                                "placeholder" : "Résultat 2020"
                                            },
                                            "res2021" : {
                                                "inputType" : "textarea",
                                                "label" : "Résultat 2019",
                                                "placeholder" : "Résultat 2021"
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },

                    "potentialite" : {
                        "title" : "Potentialité de l'action",
                        "description" : "Potentialité de l'action",
                        "icon" : "fa-thumbs-o-up",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Potentialité de l'action",
                                "type" : "object",
                                "properties" : {
                                    "technologique" : {
                                        "inputType" : "textarea",
                                        "label" : "Technologique",
                                        "placeholder" : "Technologique",
                                        "class" : "description3 markdown"
                                    },
                                    "marketingTerritorial" : {
                                        "inputType" : "textarea",
                                        "label" : "Marketing territorial",
                                        "placeholder" : "Marketing territorial",
                                        "class" : "description3 markdown"
                                    },
                                    "other" : {
                                        "inputType" : "textarea",
                                        "label" : "Autre",
                                        "placeholder" : "Autre (à préciser)…",
                                        "class" : "description3 markdown"
                                    }
                                }
                            }
                        }
                    },
                    "swot" : {
                        "title" : "Analyse SWOT",
                        "description" : "Analyse SWOT",
                        "icon" : "fa-thumbs-o-up",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Analyse SWOT",
                                "type" : "object",
                                "properties" : {
                                    "opportunite" : {
                                        "inputType" : "textarea",
                                        "label" : "Opportunité",
                                        "placeholder" : "Opportunité",
                                        "class" : "description3 markdown"
                                    },
                                    "force" : {
                                        "inputType" : "textarea",
                                        "label" : "Force",
                                        "placeholder" : "Force",
                                        "class" : "description3 markdown"
                                    },
                                    "menaces" : {
                                        "inputType" : "textarea",
                                        "label" : "Menaces",
                                        "placeholder" : "Menaces",
                                        "class" : "description3 markdown"
                                    },
                                    "faiblesse" : {
                                        "inputType" : "textarea",
                                        "label" : "Faiblesse",
                                        "placeholder" : "Faiblesse",
                                        "class" : "description3 markdown"
                                    }
                                }
                            }
                        }
                    },
                    "validationTech" : {
                        "title" : "Validation Technique de l'action",
                        "description" : "Validation Technique de l'action",
                        "icon" : "fa-cogs",
                        "titleClass" : "text-red",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Validation Technique de l'action",
                                "type" : "object",
                                "properties" : {
                                    "confirmationTech" : {
                                        "inputType" : "select",
                                        "label" : "Validation",
                                        "placeholder" : "Confirmez l'aspect technique",
                                        "options" : {
                                            "valider" : "Valider",
                                            "pending" : "En attente",
                                            "refuser" : "Refuser"
                                        }
                                    },
                                    "technique" : {
                                        "inputType" : "textarea",
                                        "label" : "Validation technique",
                                        "placeholder" : "Avis",
                                        "class" : "description3 markdown"
                                    },
                                    "techniqueDate" : {
                                        "inputType" : "date",
                                        "label" : "Date de la validation technique",
                                        "placeholder" : "Date de la validation technique"
                                    }
                                }
                            }
                        }
                    },
                    "validationFinance" : {
                        "title" : "Validation Financière de l'action",
                        "description" : "Validation Finance de l'action",
                        "icon" : "fa-money",
                        "titleClass" : "text-red",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Validation Finance de l'action",
                                "type" : "object",
                                "properties" : {
                                    "confirmationFinance" : {
                                        "inputType" : "select",
                                        "label" : "Validation",
                                        "placeholder" : "Confirmez l'aspect financier",
                                        "options" : {
                                            "valider" : "Valider",
                                            "pending" : "En attente",
                                            "refuser" : "Refuser"
                                        }
                                    },
                                    "financière" : {
                                        "inputType" : "textarea",
                                        "label" : "Validation financière",
                                        "placeholder" : "Avis",
                                        "class" : "description3 markdown"
                                    },
                                    "financiereDate" : {
                                        "inputType" : "date",
                                        "label" : "Date de la validation financière",
                                        "placeholder" : "Date de la validation financière"
                                    }
                                }
                            }
                        }
                    },
                    "validationJuridique" : {
                        "title" : "Validation Juridique de l'action",
                        "description" : "Validation Juridique de l'action",
                        "icon" : "fa-gavel",
                        "titleClass" : "text-red",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Validation Juridique de l'action",
                                "type" : "object",
                                "properties" : {
                                    "confirmationJuridique" : {
                                        "inputType" : "select",
                                        "label" : "Validation",
                                        "placeholder" : "Confirmez l'aspect juridique",
                                        "options" : {
                                            "valider" : "Valider",
                                            "pending" : "En attente",
                                            "refuser" : "Refuser"
                                        }
                                    },
                                    "juridique" : {
                                        "inputType" : "textarea",
                                        "label" : "Validation juridique",
                                        "placeholder" : "Avis",
                                        "class" : "description3 markdown"
                                    },
                                    "juridiqueDate" : {
                                        "inputType" : "date",
                                        "label" : "Date de la validation juridique",
                                        "placeholder" : "Date de la validation juridique"
                                    }
                                }
                            }
                        }
                    },


                                    "calendar" : {
                        "title" : "Calendrier",
                        "description" : "Etapes clefs de la fiche action",
                        "arrayForm" : true,
                        "icon" : "fa-calendar",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Calendier",
                                "icon" : "fa-calendar",
                                "properties" : {
                                    "results" : {
                                        "inputType" : "arrayForm",
                                        "properties" : {
                                            "step" : {
                                                "inputType" : "text",
                                                "label" : "Etape",
                                                "placeholder" : "Début, fin, étapes, milestone, rendu ..."
                                            },
                                            "date" : {
                                                "inputType" : "date",
                                                "label" : "Date",
                                                "placeholder" : "Donnez une date acette étape"
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "validation" : {
                        "title" : "Financement",
                        "description" : "Financement",
                        "icon" : "fa-thumbs-o-up",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Validation de l'action",
                                "type" : "object",
                                "properties" : {
                                    "techniqueDate" : {
                                        "inputType" : "date",
                                        "label" : "Date de la validation technique",
                                        "placeholder" : "Date de la validation technique"
                                    },
                                    "financière" : {
                                        "inputType" : "textarea",
                                        "label" : "Validation financière",
                                        "placeholder" : "Avis",
                                        "class" : "description3 markdown"
                                    },
                                    "financiereDate" : {
                                        "inputType" : "date",
                                        "label" : "Date de la validation financière",
                                        "placeholder" : "Date de la validation financière"
                                    },
                                    "juridique" : {
                                        "inputType" : "textarea",
                                        "label" : "Validation juridique",
                                        "placeholder" : "Avis",
                                        "class" : "description3 markdown"
                                    },
                                    "juridiqueDate" : {
                                        "inputType" : "date",
                                        "label" : "Date de la validation juridique",
                                        "placeholder" : "Date de la validation juridique"
                                    }
                                }
                            }
                        }
                    },
                    "estimation" : {
                        "title" : "Plan de Financement",
                        "description" : "liste des projets associés à cette fiche action",
                        "arrayForm" : true,
                        "icon" : "fa-money",
                        "json" : {
                            "jsonSchema" : {
                                "title" : "Quel financement",
                                "icon" : "fa-money",
                                "properties" : {
                                    "financement" : {
                                        "title" : "Plan de Financement",
                                        "icon" : "fa-money",
                                        "inputType" : "arrayForm",
                                        "properties" : {
                                            "project" : {
                                                "placeholder" : "Choisissez un projet"
                                            },
                                            "public" : {
                                                "placeholder" : "Financement Public"
                                            },
                                            "amount" : {
                                                "placeholder" : "Montant du Financement"
                                            },
                                            "year" : {
                                                "placeholder" : "Année du Financement"
                                            },
                                            "percent" : {
                                                "placeholder" : "Quelle part du projet globale"
                                            },
                                            "financer" : {
                                                "placeholder" : "Cadre d'intervention"
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
} ```