import React from 'react';
import styled from 'styled-components';


const StyledBox = styled.div`
    display: block;
    background-color: red;
    width: 250px;
    height: 250px;
`;


function Example() {
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Example Component</div>
                        <StyledBox />

                        <div className="card-body">I'm an example component!</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Example;
