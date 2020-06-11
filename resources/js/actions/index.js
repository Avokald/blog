import action from './action';
import ApiRequest from "../routes/ApiRouter";

export const getMetadata = () => action('metadata', ApiRequest.route('metadata'));

export const getUserProfile = (userId) => action('user', ApiRequest.route('user', [userId]));

export const getUserComments = (userId) => action('userComments', ApiRequest.route('userComments', [userId]));

export const getUserDrafts = (userId) => action('userDrafts', ApiRequest.route('userDrafts', [userId]));

export const getUserBookmarkPosts = (userId) => action('userBookmarkPosts', ApiRequest.route('userBookmarkPosts', [userId]));

export const getCategories = () => action('categories', ApiRequest.route('categories'));

export const getPost = (postId) => action('post', ApiRequest.route('post', [postId]));

export const getCategory = (slug) => action('category', ApiRequest.route('category', [slug]));
