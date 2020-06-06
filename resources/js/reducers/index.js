import {combineReducers} from 'redux';
import postsReducer from './posts';
import categoriesReducer from './categories';
import tagsReducer from './tags';

const appReducer = combineReducers({
    posts: postsReducer,
    categories: categoriesReducer,
    tags: tagsReducer,
});

export default appReducer;
