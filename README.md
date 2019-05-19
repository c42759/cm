## Challenge

1. Add *Apache htdocs* files into your public folder from your localhost Apache Server;
2. Run *Api ZF3* with `composer serve `;
3. Use browser to access to http://localhost/unit-test.html



## API (ZF3)

`POST /api/name`

Verify if name isn't empty and send it to upstream service (if is available);



`POST /api/number`

Verify if numberisn't empty and send it to upstream service (if is available);



`POST /api/email`

Verify if email isn't empty and send it to upstream service (if is available);



## UPSTREAM SERVICE (PHP Native)

`POST ?action=saveName`

Append received name to a text file;



`POST ?action=saveNumber`

Append received number to a text file;



`POST ?action=saveEmail`

Append received email to a text file;

