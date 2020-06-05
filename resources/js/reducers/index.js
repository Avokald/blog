import {combineReducers} from 'redux';
import postsReducer from './posts';
import categoriesReducer from './categories';

const appReducer = combineReducers({
    posts: postsReducer,
    categories: categoriesReducer,
});

export default appReducer;
