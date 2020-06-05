import React from 'react';
import styled from 'styled-components';
import {Link} from "react-router-dom";

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

const Header = () => (
    <StyledHeader>
        <Link to="/">Home</Link>
        <StyledRightHeader>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        </StyledRightHeader>
    </StyledHeader>
);

export default Header;