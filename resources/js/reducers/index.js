import {combineReducers} from 'redux';
import postsReducer from './posts';

const appReducer = combineReducers({
    posts: postsReducer,
});

export default appReducer;
