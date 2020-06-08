import action from './action';
import ApiRequest from "../routes/ApiRouter";

export const getUserProfile = (userId) => action('user', ApiRequest.route('user', [userId]));

export const getCategories = () => action('categories', ApiRequest.route('categories'));

export const getPost = (postId) => action('post', ApiRequest.route('post', [postId]));

export const getCategory = (slug) => action('category', ApiRequest.route('category', [slug]));