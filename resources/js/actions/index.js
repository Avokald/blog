import action from './action';
import ApiRequest from "../routes/ApiRouter";

export const fetchUserProfile = (userId) => action('user', ApiRequest.route('user', [userId]));

export const fetchCategories = () => action('categories', ApiRequest.route('categories'));
