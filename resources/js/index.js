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
import webRouter from "./routes/WebRouter";
import PageNew from "./containers/PageNew";
import {getCategories} from "./actions";


const StyledApp = styled.div`
    
`;

const StyledMain = styled.main`
    display: flex;
    width: 100%;
    align-items: stratch;
`;

const StyledContent = styled.div`
    
`;

const ButtonToTop = styled.div`
    display: block;
    width: 50px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    cursor: pointer;
    
    &>div {
        display: block;
        width: 50px;
        height: 100vh;
        position: fixed;
        top: 0;          
        left: -50px;
        opacity: 0.1;
        background-color: grey;
        transition: left 0.1s ease-in; 
        
    }
    
    &:hover {
      &>div {
        
        left: 0;
      }
    }
    
`;

store.dispatch(getCategories());

const app = (
    <Provider store={store}>
        <BrowserRouter>
            <div>
               <Header />

                <StyledMain>
                    <Sidebar />

                    <StyledContent>
                        <Switch>
                            <Route exact path={webRouter.path('frontpage')} component={PostList} />
                            <Route exact path={webRouter.path('pageNew')} component={PageNew} />
                            <Route exact path={webRouter.path('post')} component={PostView} />

                            <Route exact path={webRouter.path('user')}
                                   component={UserProfile} />

                            <Route exact path="/users/" component={Users} />

                            <Route exact path={webRouter.path('tag')} component={Tag} />
                            <Route exact path="/tags" component={Tags} />

                            <Route exact path="/categories" component={Categories} />
                            <Route exact path={webRouter.path('category')} component={Category} />
                        </Switch>
                    </StyledContent>
                </StyledMain>
            </div>
            <div style={{ height: "1000px" }}/>
            <ButtonToTop onClick={ () => window.scrollTo(0, 0) } >
                <div></div>
            </ButtonToTop>
        </BrowserRouter>
    </Provider>
);

ReactDOM.render(app, document.getElementById('app'));