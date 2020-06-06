import React from 'react';
import {connect} from 'react-redux';
import {fetchUserProfile} from "../../../actions";

class UserProfile extends React.Component {

    componentDidMount() {
       this.props.fetchUserProfile(this.props.match.params.slugged_id.split('-')[0]);
    }

    render() {
        const user = this.props.profile;
        return (
            <div>User Profile
                <p>Banner: {user.banner}</p>
                <p>Image: {user.image}</p>
                <h1>Name: {user.name}</h1>
                <p>Description: {user.description}</p>
                <p>Created: {user.created_at}</p>
            </div>

        );
    }
}


const mapStateToProps = (state) => {
   return {
       profile: state.user.data,
   };
};

const mapDispatchToProps = (dispatch) => ({
    fetchUserProfile: (userId) => dispatch(fetchUserProfile(userId)),
});

export default connect(mapStateToProps, mapDispatchToProps)(UserProfile);