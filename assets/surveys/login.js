dynForm = {
    "jsonSchema" : {
        "title" : "Identity",
        "icon" : "user",
        onLoads : {
            onload : function(){
                dyFInputs.setHeader("bg-green");
            }
        },
        "properties" : {
            info : {
                inputType : "custom",
                html:"<p class=''>"+
                        "Please share who you are ...<hr>" +
                     "</p>",
            },
            "email" : {
                "inputType" : "text",
                "placeholder" : "albert@einstein.org"
            }
        }
    }
}