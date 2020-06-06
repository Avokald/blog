import React from 'react';
import {connect} from 'react-redux';
import {Link} from "react-router-dom";

class Users extends React.Component {
    render() {
        const users = this.props.users;
        return (
            <div>
                { users.map((user) => {
                    return (
                        <div key={user.id}>
                            <h2>
                                <Link to={'/u/' + user.id + '-' + user.slug}>
                                    {user.name}
                                </Link>
                            </h2>
                            <p>{user.description}</p>

                        </div>
                    );
                }) }
            </div>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        users: state.users,
    };
};

export default connect(mapStateToProps, null)(Users);