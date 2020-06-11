import React from 'react';
import styled from 'styled-components';
import {Link} from "react-router-dom";
import {connect} from 'react-redux';

const StyledHeader = styled.div`
    display: flex;
    justify-content: space-between;
`;

const StyledRightHeader = styled.div`
    display: inline-block;
    a {
        margin-left: 20px;
    }
`;

const Header = (props) => (
    <StyledHeader>
        <Link to="/">Home</Link>
        <StyledRightHeader>
            <form action="/logout" method="post" id="logout" hidden="hidden" />
            { (props.user && (
                <p>{props.user.name} &nbsp;
                    <input type="submit" form="logout" className="btn btn-info" value="Logout" />
                </p>
            )) || (
                <React.Fragment>
                    <a href="/login">Login</a>
                    <a href="/register">Register</a>
                </React.Fragment>
            )}

        </StyledRightHeader>
    </StyledHeader>
);

const mapStateToProps = (state) => ({
    user: state.metadata.data.user,
});
export default connect(mapStateToProps, null)(Header);