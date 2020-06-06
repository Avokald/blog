import {combineReducers} from 'redux';
import postsReducer from './posts';
import categoriesReducer from './categories';
import tagsReducer from './tags';
import usersReducer from './users';

const appReducer = combineReducers({
    posts: postsReducer,
    categories: categoriesReducer,
    tags: tagsReducer,
    users: usersReducer,
});

export default appReducer;
