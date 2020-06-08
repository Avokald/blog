// https://github.com/Avokald/opendota-web/blob/master/src/actions/action.js
import querystring from 'querystring';

export default function action(type, link, params = {}) {
    return (dispatch) => {
        const url = `${link}?${typeof params === 'string' ? params.substring(1) : querystring.stringify(params)}`;
        const getDataStart = () => ({
            type: `REQUEST/${type}`,
        });
        const getDataOk = payload => ({
            type: `OK/${type}`,
            payload,
        });
        const getError = error => ({
            type: `ERROR/${type}`,
            error,
        });
        const fetchDataWithRetry = delay => fetch(url)
            .then((response) => {
                if (!response.ok || !response.status) {
                    const err = new Error();
                    err.fetchError = true;
                    dispatch(getError(response.status));
                    if (response.status >= 400 && response.status < 500) {
                        err.clientError = true;
                        err.message = 'fetch failed - client error';
                    } else {
                        err.message = 'fetch failed - retrying';
                    }
                    throw err;
                }
                return response.json();
            })
            .then(json => dispatch(getDataOk(json)))
            .catch((e) => {
                console.error(e);
                if (e.fetchError && !e.clientError) {
                    setTimeout(() => fetchDataWithRetry(delay + 3000), delay);
                }
                if (!e.fetchError) {
                    throw e;
                }
            });
        dispatch(getDataStart());
        return fetchDataWithRetry(1000);
    };
};