showUserInfos();

function formatName(user) {
    return user.firstName + ' ' + user.lastName;
}

function createElement(user) {
  const element = <h1>Bonjour, {formatName(user)} !</h1>;
  return element;
}

function renderUser(user) {
  ReactDOM.render(
    createElement(user),
    document.getElementById('application_body')
  );
}

async function showUserInfos() {
  renderUser(await getJsonByAPI('?ajax=true&action=getUserInfos&page=user'));
}

function getJsonByAPI(url) {
  return new Promise(resolve => {
    fetch(url)
      .then(async response => {
          const data = await response.json();

          // check for error response
          if (!response.ok) {
              // get error message from body or default to response statusText
              const error = (data && data.message) || response.statusText;
              return Promise.reject(error);
          }
          resolve(data);

      })
      .catch(error => {
          console.error('There was an error!', error);
      });
  });
}