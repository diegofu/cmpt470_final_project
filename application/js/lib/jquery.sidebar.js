/*! jQuery SideBar - v1.0.2 - 2012-11-04
* https://github.com/sideroad/jquery.sidebar
* Copyright (c) 2012 sideroad; Licensed MIT, GPL */

(function( $, _window ) {
    $.fn.sidebar = function(options){
        
        
        return this.each(function(){
            
            var elem = $(this),
                data = elem.data("sidebar")||{},
                margin,
                width,
                height,
                duration = data.duration,
                injectWidth,
                injectHeight,
                injectCss,
                containerCss,
                bodyCss,
                position,
                enter,
                leave,
                opened,
                closed,
                isInnerElement,
                container = $("<div><div/>"),
                inject = $("<div><div/>"),
                body = $("<div><div/>"),
                root,
                parent,
                open = function(){
                    var data = elem.data("sidebar") || {},
                        opened = data.callback.sidebar.open,
                        container = data.container,
                        inject = data.inject,
                        body = data.body;
                    
                    if (data.isEnter || data.isProcessing) {
                        return;
                    }
                    data.isEnter = true;
                    data.isProcessing = true;
                    container.animate(data.animate.container.enter, {
                        duration: duration,
                        complete: function(){
                            body.show("clip", duration,function(){
                                data.isProcessing = false;
                                if(opened) {
                                    opened();
                                }
                            });
                            inject.attr('class','sidebar-inject right');
                        }
                    });
                },
                close = function(){
                    var data = elem.data("sidebar") || {},
                        closed = data.callback.sidebar.close,
                        container = data.container,
                        inject = data.inject,
                        body = data.body;
                       
                    if(!data.isEnter || data.isProcessing ) {
                        return;
                    }
                    data.isProcessing = true;
                    container.animate(data.animate.container.leave, {
                        duration: duration,
                        complete: function(){
                            body.hide("clip", duration, function(){
                                inject.fadeIn(duration, function(){
                                    data.isEnter = false;
                                    data.isProcessing = false;
                                    if(closed) {
                                        closed();
                                    }
                                });
                            });
                            inject.attr('class','sidebar-inject left');
                        }
                    });
                };
            
            
            if(typeof options === "string"){
                switch(options){
                    case "open" :
                        open();
                        break;
                    case "close" : 
                        close();
                        break;
                }
                return;
            }
                
            //default setting
            options = $.extend(true, {
                root : $(document.body),
                position : "left",
                callback: {
                    item : {
                        enter : function(){
                            $(this).animate({marginLeft:"5px"},250);
                        },
                        leave : function(){
                            $(this).animate({marginLeft:"0px"},250);
                        }
                    },
                    sidebar : {
                        open : function(){
                            
                        },
                        close : function(){
                            
                        }
                    }
                },
                animate : {
                    container : {
                        enter : {},
                        leave : {}
                    }
                },
                duration : 200,
                open : "mouseenter.sidebar",
                close : "mouseleave.sidebar"
            }, options);
            
            root = options.root;
            isInnerElement = !root.is(document.body);
            parent = ( isInnerElement ) ? root.addClass("sidebar-root") : $(_window);
            
            position = options.position;
            duration = options.duration;
            
            container.attr("id", "jquerySideBar" + new Date().getTime()).addClass("sidebar-container").addClass(position);
            inject.addClass("sidebar-inject").addClass(position);
            body.addClass("sidebar-body");
            
            //append to body
            body.append(this);
            container.append(body);
            container.append(inject);
            root.append(container);
            
            width = container.width();
            height = container.height();
            injectWidth = inject.width();
            injectHeight = inject.height();
            
            containerCss = {
                height: height,
                width: width
            };
            bodyCss = {
                height: height,
                width: width
            };
            
            if(position === "left" || position === "right") {
                margin = width - injectWidth;
                injectCss = {
                    height : height,
                    width : injectWidth
                };
                containerCss.top = options.top || (parent.height()/2) - (height/2) + "px";
                
            } else {
                margin = height - injectHeight;
                injectCss = {
                    height : injectHeight,
                    width : width
                };
                containerCss.left = options.left || (parent.width()/2) - (width/2) + "px";
            }
            
            containerCss[position] = "-" + margin + "px";
            injectCss[position] = margin + "px";
            options.animate.container.enter[position] = 0;
            options.animate.container.leave[position] = "-" + margin;
            
            //container
            container.css(containerCss);
            
            //inject
            inject.css(injectCss);
            
            //body
            body.css(bodyCss).hide();
            
            //menu callback
            $(this).addClass("sidebar-menu").find("li")
                .bind("mouseenter.sidebar",options.callback.item.enter)
                .bind("mouseleave.sidebar",options.callback.item.leave);
            
            //container events
            if(options.open) {
                container.bind(options.open,open);
            }
            if(options.close) {
                $('body').bind('click',function(e){
                    var $target = $(e.target);
                    if( $target.hasClass('sidebar-inject') ){
                        close();
                    }
                });
            }
            
            //store data
            options.container = container;
            options.inject = inject;
            options.body = body;
            elem.data("sidebar", options);
            
            parent.resize(function(){
                if(position === "left" || position === "right") {
                    container.css({top:($(this).height()/2) - (height/2) + "px"});
                } else {
                    container.css({left:($(this).width()/2) - (width/2) + "px"});
                }
            });
            
        });
    };
}(jQuery, this));