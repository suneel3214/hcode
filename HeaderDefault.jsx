import React, { useEffect } from 'react';
import Logo from '~/components/elements/common/Logo';
import {connect ,useSelector} from 'react-redux'
import SearchHeader from '~/components/shared/headers/modules/SearchHeader';
import NavigationDefault from '~/components/shared/navigation/NavigationDefault';
import HeaderActions from '~/components/shared/headers/modules/HeaderActions';
import { stickyHeader } from '~/utilities/common-helpers';
import MenuCategoriesDropdown from '~/components/shared/menus/MenuCategoriesDropdown';
import useEcomerce from '~/hooks/useEcomerce';
import useGetProducts from '~/hooks/useGetProducts';

const HeaderDefault = ({auth}) => {
    const { isLogin } = useEcomerce();
    const{logDetails,number,isLoggedIn}=auth
    const my = useSelector((state)=>state.auth)
    useEffect(async() => {
            await isLogin()

        if (process.browser) {
            window.addEventListener('scroll', stickyHeader);
        }
    }, []);
    var headerAction;
    if(isLoggedIn && number > 0){
        headerAction =  <HeaderActions logDetails={logDetails} />
    }
    else{
        headerAction =  <HeaderActions logDetails={logDetails} />
    }
       
    return (
        <header
            className="header header--1"
            data-sticky="true"
            id="headerSticky">
            <div className="header__top">
                <div className="ps-container">
                    <div className="header__left">
                        <Logo />
                        <MenuCategoriesDropdown />
                    </div>
                    <div className="header__center">
                        <SearchHeader />
                    </div>
                    <div className="header__right">
                        {headerAction}
                    </div>
                </div>
            </div>
            <NavigationDefault />
        </header>
    );
};

export default connect((state) => state)(HeaderDefault);
