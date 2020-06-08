import React from 'react';
import {Link} from "react-router-dom";
import apiRouter from "../../routes/ApiRouter";
import webRouter from "../../routes/WebRouter";

class Users extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            users: [],
        };
    }

    componentDidMount() {
        axios.get(apiRouter.route('users'))
            .then((response) => {
                this.setState({
                    users: response.data,
                });
            });
    }

    render() {
        const { users } = this.state;
        return (
            <div>
                { users.map((user) => {
                    return (
                        <div key={user.id}>
                            <h2>
                                <Link to={ webRouter.route('user', [user.id + '-' + user.slug]) }>
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

export default Users;