import React from 'react';
import {connect} from 'react-redux';

class UserProfile extends React.Component {
    render() {
        const user = this.props.user;
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


const mapStateToProps = (state, props) => {
   let currentUser = null;
   let sluggedId = props.match.params.slugged_id;
   let id = sluggedId.split('-')[0];

   console.log(sluggedId, id);
   for (let user of state.users) {
       if (Number(user.id) === Number(id)) {
           currentUser = user;
       }
   }

   console.log(currentUser);
   return {
       user: currentUser,
   };

};

export default connect(mapStateToProps, null)(UserProfile);