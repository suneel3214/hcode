import React, { useState } from 'react';
import ProductRepository from '~/repositories/ProductRepository';
import CartRepository from '~/repositories/CartRepository';
import AuthRepository from '~/repositories/AuthRepository';
import { useCookies } from 'react-cookie';
import { useDispatch,useSelector } from 'react-redux';
import { useRouter } from 'next/router';
import { updateChatUserToCookies,updateChatRoomToCookies } from '../utilities/ecomerce-helpers.js'

import {
    setCompareItems,
    setWishlistTtems,
    setCartItems,
    setAddress,
    setOrderDetails,
    placeBid,
    ProductDetails,
    ShippingUpdate,
    orderDetails
} from '~/store/ecomerce/action';

import {
    login,
    checkLogin,
    chatUser,
    chatMessage,
    allChatUser,
    chatBoxUser,
    deleteChatBox
} from '~/store/auth/action';

export default function useEcomerce() {
    const dispatch = useDispatch();
    const [loading, setLoading] = useState(false);
    const [cartItemsOnCookie] = useState(null);
    const [cookies, setCookie] = useCookies();
    const [products, setProducts] = useState(null);
    const [wishlist, setwishList] = useState({});
    const Router = useRouter();


    return {
        loading,
        cartItemsOnCookie,
        products,
        getProducts: async (payload, group = '') => {
            setLoading(true);
            // if (payload && payload.length > 0) {
               
                var responseData = await CartRepository.getCart();
                responseData = responseData.data
                dispatch(setCartItems(responseData));
                if (responseData && responseData.cart_items.length > 0) {
                    if (group === 'cart') {
                        let cartItems = responseData.cart_items;
                        cartItems.forEach((item) => {
                            let existItem = cartItems.find(
                                (val) => val.id === item.id
                            );

                            if (existItem) {
                                existItem.quantity = item.quantity;
                            }
                        });
                        setProducts(cartItems);
                    } else {
                        setProducts(responseData);
                    }
                    setTimeout(
                        function () {
                            setLoading(false);
                        }.bind(this),
                        250
                    );
                }
                else {
                    setLoading(false);
                    setProducts([]);
                }
    
        },

        increaseQty: async (payload, currentCart) => {
            let cart = [];
            if (currentCart) {
                // cart = currentCart;
                // const existItem = cart.find((item) => item.id === payload.id);
                // if (existItem) {
                //     existItem.quantity = existItem.quantity + 1;
                // }
                setCookie('cart', cart, { path: '/' });
                var responseData = await CartRepository.updateCart(payload);
                dispatch(setCartItems(responseData.data));
                if(responseData){
                    return true
                }
                return false
            }
            return cart;
        },

        decreaseQty: async(payload, currentCart) => {
            let cart = [];
            if (currentCart) {
                // cart = currentCart;
                // const existItem = cart.find((item) => item.id === payload.id);
                // if (existItem) {
                //     if (existItem.quantity > 1) {
                //         existItem.quantity = existItem.quantity - 1;
                //     }
                // }
                // setCookie('cart', cart, { path: '/' });
                var responseData = await CartRepository.updateCart(payload);
                dispatch(setCartItems(responseData.data));
                if(responseData){
                    return true
                }
                return false
            }
            return cart;
        },

        addItem: async (newItem, items, group) => {
            let newItems = [];
            // if (items) {
            //     newItems = items;
            //     const existItem = items.find((item) => item.id === newItem.id);
            //     if (existItem) {
            //         if (group === 'cart') {
            //             existItem.quantity += newItem.quantity;
            //         }
            //     } else {
            //         newItems.push(newItem);
            //     }
            // } else {
            //     newItems.push(newItem);
            // }
            if (group === 'buy') {
                setCookie('cart', newItems, { path: '/' });
                var cart = await CartRepository.addToCart(newItem)
                dispatch(setCartItems(cart.data));
            }
            if (group === 'cart') {
                setCookie('cart', newItems, { path: '/' });
                var cart = await CartRepository.addToCart(newItem)
                dispatch(setCartItems(cart.data));
            }
            if (group === 'wishlist') {
                setCookie('wishlist', newItems, { path: '/' });
                var responseData = await CartRepository.addWishList(newItem);
                if(responseData){
                    dispatch(setWishlistTtems(responseData));
                }
                return responseData;
            }

            if (group === 'compare') {
                setCookie('compare', newItems, { path: '/' });
                dispatch(setCompareItems(newItems));
            }
            return newItems;
        },

        removeItem: async (selectedItem, items, group) => {
            // let {cart_items} = items;
            // console.log(selectedItem.id)
            if (group === 'cart') {
                setCookie('cart', items, { path: '/' });
                var responseData = await CartRepository.deleteCart(selectedItem.id);
                dispatch(setCartItems(responseData));
            }

            // if (cart_items.length > 0) {
            //     const index = cart_items.findIndex(
            //         (item) => item.id === selectedItem.id
            //     );
            //     cart_items.splice(index, 1);
            // }
           
            if (group === 'wishlist') {
                setCookie('wishlist', selectedItem, { path: '/' });
                var responseData = await CartRepository.removeWishList(selectedItem);
                dispatch(setWishlistTtems(responseData));
            }

            if (group === 'compare') {
                setCookie('compare', selectedItem, { path: '/' });
            }
        },

        removeItems: (group) => {
            if (group === 'wishlist') {
                setCookie('wishlist', [], { path: '/' });
                dispatch(setWishlistTtems([]));
            }
            if (group === 'compare') {
                setCookie('compare', [], { path: '/' });
                dispatch(setCompareItems([]));
            }
            if (group === 'cart') {
                setCookie('cart', [], { path: '/' });
                dispatch(setCartItems([]));
            }
        },

        selectAddress:(address)=>{
            dispatch(setAddress(address));
        },

        checkout: async (address,paymentId)=>{
            var data={
                address:address,
                paymentId:paymentId
            }
            var responseData = await CartRepository.checkout(data);
            dispatch(setOrderDetails(responseData.data));
            return responseData;
        },

        placeBid:async (params)=>{
            var responseData = await CartRepository.placeBid(params);
            // console.log(responseData)
            dispatch(ProductDetails(responseData));
            dispatch(placeBid());
        },

        getWishList:async()=>{
            var responseData = await CartRepository.wishList();
            console.log('wishlist',responseData)
            dispatch(setWishlistTtems(responseData));
            setwishList(responseData)
        },

        getLogUser: async ()=>{
            var response = await AuthRepository.getUserDetails();
            dispatch(login(response,false));
        },

        updateUserDetails:async (params)=>{
            var response = await AuthRepository.updateUserDetails(params);
            return response;
        },

        orderDetails:async ()=>{
            var response = await AuthRepository.getOrderDetails();
            return response;
        },

        isLogin:async()=>{
             if(typeof window !== 'undefined' && localStorage){
                if(!localStorage.token){
                    return false;
                }

                var response = await AuthRepository.getUserDetails();
                dispatch(checkLogin(response)); 
                return response            
            }
        },

        getBidHistory:async(proId)=>{
            var responseData = await CartRepository.getBidHistory(proId);
            return  responseData;
        },

        getProductsDetils:async(proId)=>{
            var responseData = await ProductRepository.getProductsById(proId);
            // console.log('responseData')
            dispatch(ProductDetails(responseData));
            return responseData;
        },

        getContactList:async()=>{
            var response = await AuthRepository.getConnectedUser();
            if(response.length > 0){
                // dispatch(chatUser(response[0]));
                dispatch(allChatUser(response));
            }
            return response 
        },

        logout:async()=>{
            var response = await AuthRepository.logout();
            return response 
        },

        getMessages:async(chatroomId,userId,senderID='')=>{
            var {messages,user} = await AuthRepository.getMessages(chatroomId,userId,senderID);
            updateChatUserToCookies(user.UserId)
            updateChatRoomToCookies(chatroomId)
            parseInt(localStorage.setItem('my',user.UserId) )
            parseInt(localStorage.setItem('cr',chatroomId) )


            dispatch(chatBoxUser(user,messages));
            dispatch(chatMessage(messages));
            return messages 
        },
        startChatWithSeller:async(sellerId)=>{
            var {messages,user} = await AuthRepository.startChat(sellerId);
            localStorage.setItem('my',user.UserId)
            dispatch(chatBoxUser(user,messages));
            dispatch(chatUser(user));
            dispatch(chatMessage(messages));
            return user 
        },
        deleteChatBox:async()=>{
            dispatch(deleteChatBox())
        },
        saveReview:async(data)=>{
            var responseData = ProductRepository.saveReview(data)
            return responseData;
        },
        saveReport:async(data)=>{
            var responseData = ProductRepository.saveReport(data)
            return responseData;
        },
        updateShipping:async()=>{
            dispatch(ShippingUpdate())
        },
        isCartEmpty:async()=>{
            var responseData = await CartRepository.isCartEmpty();
            return  responseData.data;
        },
        getOrderByNumber:async(orderNumbers)=>{
            var responseData = await CartRepository.getOrderByNubmer(orderNumbers);
            dispatch(orderDetails(responseData));
            return  responseData;
        }
    };
}
