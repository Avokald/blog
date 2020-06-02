import {applyMiddleware, compose, createStore} from 'redux';
import app from '../reducers';

/* eslint-disable no-underscore-dangle */
// This enables the redux dev tools extension, or does nothing if not installed
const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
/* eslint-enable */

const logger = (store) => {
    return next => {
        return action => {
            console.log("Current action: ", action);
            const result = next(action);
            console.log("Result: ", result);
            return result;
        }
    }
};

const store = createStore(
    app,
    composeEnhancers(applyMiddleware(logger))
);

export default store;