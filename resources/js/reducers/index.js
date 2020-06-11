import {combineReducers} from 'redux';
import reducer from './reducer';
import postsReducer from './posts';
import tagsReducer from './tags';
import usersReducer from './users';


const categoriesInitialState = [
  {
    "id": 1,
    "title": "testcat",
    "slug": "testcat",
    "description": "testdesc",
    "image": "https://lorempixel.com/120/120/?61201",
    "banner": "https://lorempixel.com/640/160/?19156",
    "created_at": "2020-05-31 18:53:32",
    "updated_at": "2020-05-31 18:53:32",
    "link": "http://0.0.0.0/testcat"
  },
  {
    "id": 2,
    "title": "cupiditate",
    "slug": "cupiditate",
    "description": "Ad cumque est temporibus suscipit sapiente molestias aut.",
    "image": "https://lorempixel.com/120/120/?41421",
    "banner": "https://lorempixel.com/640/160/?88199",
    "created_at": "2020-05-31 18:53:32",
    "updated_at": "2020-05-31 18:53:32",
    "link": "http://0.0.0.0/cupiditate"
  },
  {
    "id": 3,
    "title": "minima",
    "slug": "minima",
    "description": "Aliquid necessitatibus exercitationem facere possimus id quis et necessitatibus.",
    "image": "https://lorempixel.com/120/120/?72254",
    "banner": "https://lorempixel.com/640/160/?89472",
    "created_at": "2020-05-31 18:53:32",
    "updated_at": "2020-05-31 18:53:32",
    "link": "http://0.0.0.0/minima"
  },
];

const appReducer = combineReducers({
    posts: postsReducer,
    categories: reducer('categories', categoriesInitialState),
    tags: tagsReducer,
    users: usersReducer,

    user: reducer('user'),
    userComments: reducer('userComments'),
    userDrafts: reducer('userDrafts'),
    userBookmarkPosts: reducer('userBookmarkPosts'),

    category: reducer('category'),
    tag: reducer('tag'),
    post: reducer('post'),
});

export default appReducer;
