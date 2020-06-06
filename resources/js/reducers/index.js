import {combineReducers} from 'redux';
import reducer from './reducer';
import postsReducer from './posts';
import categoriesReducer from './categories';
import tagsReducer from './tags';
import usersReducer from './users';

const appReducer = combineReducers({
    posts: postsReducer,
    categories: categoriesReducer,
    tags: tagsReducer,
    users: usersReducer,
    user: reducer('user'),
    category: reducer('category'),
    tag: reducer('tag'),
    post: reducer('post'),
});

export default appReducer;
