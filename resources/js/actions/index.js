import action from './action';

export const fetchUserProfile = (userId) => action('user', process.env.MIX_APP_API_HOST, `api/v1/u/${userId}`);
