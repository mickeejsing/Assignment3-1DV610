# Assignment 2 1DV610

I det här uppdraget har jag lagt till 2 stycken use-cases som har testats manuellt. De use case jag har lagt till är mail-funktionalitet och översättning till morsekod.

## UC Skicka mail

### Main Scenario

1. Startar när användaren vill skicka ett mail.
2. Systemet uppvisar ett formulär där uppgifter efterfrågas.
3. Användaren fyller i samtliga uppgifter och klickar därefter på knappen skicka mail.
4. Systemet skickar mailet och meddelar sedan att mailet har skickats.

### Alternate Scenario

3. a) Användaren fyller endast i titel och klickar sedan på knappen skicka mail.
1. Systemet påtalar att användaren inte har angett avsändare, mottagare och meddelande. Meddelandet skickas inte.

3. b) Användaren anger en felaktig användare (mickeejsinggmail.com).
1. Systemet påtalar att användaren har angett en felaktig address. Meddelandet skickas inte.

4. a) Ett fel har inträffat (t.ex. intenetuppkopplingen är nere). Systemet kastar ett undantag, därefter presenteras felmeddelandet "The mail was not sent".

## UC Generera morsekod

### Main Scenario

1. Startar när användaren vill skicka ett mail formaterat enligt morsekod. Användaren anger texten "I would like to genereate some morse code".
2. Systemet uppvisar en checkbox för generering av morsekod.
3. Användaren anger att morsekod skall genereras, genom att markera motsvarande checkbox.
4. Systemet genererar och skickar fölande meddelande: .. / .-- --- ..- .-.. -.. / .-.. .. -.- . / - --- / --. . -. . .-. . .- - . / ... --- -- . / -- --- .-. ... . / -.-. --- -.. .


För att tolka meddelanden kan följande tjänst användas.

https://morsecode.world/international/translator.html