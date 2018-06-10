/** Contains login and registration procedures */

/** Throws an generic error so we know that authentication has failed.*/
function handleErrors(response) {
    if (!response.ok) {
        throw Error(response.statusText);
    }
    return response;
}

/** Sends fetch request to login user (better usability) */
function login(elemUsername, elemClearPwd) {
    let headers = new Headers();
    headers.append('Accept','application/json, application/xml, text/plain, text/html, *.*');
    headers.append('Content-Type','application/x-www-form-urlencoded; charset=utf-8');

    let urlSearchParams = new URLSearchParams();
    urlSearchParams.append('userName',elemUsername.value);
    urlSearchParams.append('clearPassword',elemClearPwd.value);


    fetch("./AuthenticationMiddleware.php",
        {
            credentials: 'include',
            method: "post",
            headers: headers,
            body: urlSearchParams
        })
        .then(handleErrors)
        .then((resp) => resp.json())
        .then(function(res) {
            console.log('Submitted userCredentialsJson.');
            window.location.href = "./modelupload.php"; //redirect to modelupload page
        })
        .catch(function(error) {
            new PNotify({
                title: 'Unauthorized',
                text: 'Username or password is wrong.',
                type: 'error',
                styling: 'bootstrap3'
            });

        });
}