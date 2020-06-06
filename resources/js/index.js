import React from 'react';
import ReactDOM from 'react-dom';
import {Provider} from 'react-redux';
import PostList from "./components/PostList";
import PostView from "./components/PostView";
import store from './store/index';
import {BrowserRouter, Route, Switch} from "react-router-dom";
import 'bootstrap/dist/css/bootstrap.min.css';
import styled from 'styled-components';
import Sidebar from './components/Sidebar';
import Header from "./components/Header";
import Category from "./components/Category/Category";
import Categories from "./components/Categories";
import Tags from "./components/Tag/Tags";
import Tag from "./components/Tag";
import UserProfile from "./components/User/Profile/UserProfile";
import Users from "./components/Users/Users";


const StyledApp = styled.div`
    
`;

const StyledMain = styled.main`
    display: flex;
    width: 100%;
    align-items: stratch;
`;

const StyledContent = styled.div`
    
`;

const app = (
    <Provider store={store}>
        <BrowserRouter>
            <div>
               <Header />

                <StyledMain>
                    <Sidebar />

                    <StyledContent>
                        <Switch>
                            <Route exact path="/" component={PostList} />
                            <Route exact path="/a/:slugged_id" component={PostView} />

                            <Route exact path="/u/:slugged_id" component={UserProfile} />

                            <Route exact path="/users/" component={Users} />

                            <Route exact path="/tag/:tag" component={Tag} />
                            <Route exact path="/tags" component={Tags} />

                            <Route exact path="/categories" component={Categories} />
                            <Route exact path="/:category" component={Category} />
                        </Switch>
                    </StyledContent>
                </StyledMain>
            </div>
            <div style={{ height: "1000px" }}/>
        </BrowserRouter>
    </Provider>
);

ReactDOM.render(app, document.getElementById('app'));