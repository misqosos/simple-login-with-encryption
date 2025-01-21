
<style>
    .signup-button {
        text-decoration: none;
        border-radius: 2vw;
        border: solid;
        color: rgb(122, 135, 100);
        width: 20vw;
        height: 5vw;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3vw;
        background-color: rgb(226, 226, 226);
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        transition: color 1s, background-color 1s;
        position: absolute;
        bottom: 500;
        rotate: 40deg;
        left: 700;
    }

    .login-button {
        text-decoration: none;
        border-radius: 2.5vw;
        border: solid;
        color: rgb(133, 131, 238);
        width: 14vw;
        height: 5vw;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3vw;
        background-color: rgb(252, 199, 199);
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        transition: color 1s, background-color 1s;
        position: absolute;
        bottom: 500;
        rotate: 80deg;
        left: 300;
    }

    .or {
        border: solid;
        width: 6vw;
        height: 6vw;
        border-radius: 3vw;
        border-color: black;
        border-width: 0.1vw;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5vw;
        position: absolute;
        bottom: 450;
        rotate: 80deg;
        left: 1000;
    }

    .login-button:hover {
        border: solid;
        color: rgb(122, 135, 100);
        font-size: 3vw;
        background-color: rgb(226, 226, 226);
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    }

    .signup-button:hover {
        border: solid;
        color: rgb(133, 131, 238);
        font-size: 3vw;
        background-color: rgb(252, 199, 199);
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
</style>

<a href="signup.php" class="signup-button" id="signup">
    Sign up
</a>

<div class="or" id="or">
    Or
</div>

<a href="login.php" class="login-button" id="login">
    Login
</a>

<script>
    fall("login");
    fall("or" , true);
    fall("signup");

    function fall (elementName, makeBall = false) {
        let el = document.getElementById(elementName);
        let elHeight = parseInt(window.getComputedStyle(el, null).getPropertyValue("bottom"));
        let elAngleFull = parseInt(window.getComputedStyle(el, null).getPropertyValue("rotate"));
        let elWidth = parseInt(window.getComputedStyle(el, null).getPropertyValue("width"));
        let elHeightDim = parseInt(window.getComputedStyle(el, null).getPropertyValue("height"));
        let elRadius = parseInt(window.getComputedStyle(el, null).getPropertyValue("border-radius")) > elHeightDim/2 ? elHeightDim/2 : parseInt(window.getComputedStyle(el, null).getPropertyValue("border-radius"));
        let elLeft = parseInt(window.getComputedStyle(el, null).getPropertyValue("left"));
        let elRight = parseInt(window.getComputedStyle(el, null).getPropertyValue("right"));
        let elBorderWidth = parseInt(window.getComputedStyle(el, null).getPropertyValue("border-width"));
        let elAngle = getAngle(elAngleFull);

        let halfCrosslineLen = Math.sqrt(Math.pow(elHeightDim/2, 2)+Math.pow(elWidth/2, 2));
        let radiusLength = (Math.sin(toRad(45+(elAngle < 45 ? elAngle : 90-elAngle)))*Math.sqrt(2)*elRadius-elRadius);
        let betaAngle = toDeg(Math.atan((elHeightDim/2)/(elWidth/2)));
        let trigoLength = Math.cos(toRad(90-(elAngle+betaAngle)))*halfCrosslineLen - elHeightDim/2;
        let tetiva = 2*halfCrosslineLen*Math.sin(toRad(elAngle/2));
        let diff = Math.sqrt(Math.pow(tetiva, 2) - Math.pow((trigoLength), 2));
        let afterFallPos = elLeft - diff;
        let afterFallPosRight = elRight + diff;

        const acc = 9.8;
        const pxToMet = 0.0002645833;
        const metToPx = 3779.5275591;
        
        let currTime = 0;
        let currHeight = 0;
        let angle = elAngleFull;
        let amp = 0;
        let angPerTime = 5;
        let hiddenPart = trigoLength - radiusLength;
        let fallen = false;
        let fixAfterFall = afterFallPos;
        let firstDiff = diff;

        let fall = setInterval(function(){
            currHeight = elHeight - 0.5*acc*currTime*currTime;
            el.style.bottom = currHeight;
            currTime += 0.1;
            if (currHeight < hiddenPart) {
                el.style.bottom = hiddenPart;
                fallen = true;
                clearInterval(fall);
            }
        },10)
        
        let intervalTime = 10;
        let rotate = setInterval(function(){
            if (fallen) {

                if (angle > 0) {
                    angPerTime-=0.016
                    if (angPerTime < 0) {
                        angPerTime = 0;
                    }
                    amp+=angPerTime;
                    let actualAngle = angle - amp;
                    if (actualAngle < 0 && !makeBall) {
                        el.style.rotate = 0+'deg';
                        el.style.bottom = 0;
                        return;
                    }

                    el.style.rotate = (actualAngle)+'deg';

                    let dist = toRad(angPerTime)*elRadius*pxToMet*metToPx;
                    
                    trigoLength = Math.cos(toRad(90-(actualAngle+betaAngle)))*halfCrosslineLen - elHeightDim/2;
                    tetiva = 2*halfCrosslineLen*Math.sin(toRad(actualAngle/2));
                    diff = Math.sqrt(Math.pow(tetiva, 2) - Math.pow((trigoLength), 2));

                    if (makeBall) {
                         elLeft -= dist;
                    } else {
                        elLeft = afterFallPos + diff;
                    }
                    el.style.left = elLeft;

                    radiusLength = (Math.sin(toRad(45+(actualAngle < 45 ? actualAngle : 90-actualAngle)))*Math.sqrt(2)*elRadius-elRadius);
                    
                    el.style.bottom = trigoLength - radiusLength;
                }
            }
        },intervalTime)
    }

    function getAngle (elAngle) {
        let angle = 0;
        for (let i = 0; i < 360/90; i++) {
            if (elAngle >= i*90) {
                angle = elAngle-i*90;
                if (i == 1 || i == 3) {
                    angle = 90 - angle;
                }
            }
        }
        return angle;
    }

    function toDeg (angle) {
        return (angle * 180)/Math.PI;
    }

    function toRad (angle) {
        return (angle * Math.PI)/180;
    }
    
</script>