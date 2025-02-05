
<?php 
if(!isset($_COOKIE["sent"])){require_once("sendMail.php");} 
?>
<style>
    .test-button {
        text-decoration: none;
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
        bottom: 0;
        rotate: 0deg;
        left: 700;
    }

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
        rotate: 86deg;
        left: 700;
    }

    .login-button {
        text-decoration: none;
        border-radius: 2vw;
        border: solid;
        color: rgb(133, 131, 238);
        width: 14vw;
        height: 10vw;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3vw;
        background-color: rgb(252, 199, 199);
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        transition: color 1s, background-color 1s;
        position: absolute;
        bottom: 500;
        rotate: 21440deg;
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
        left: 20;
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

<div style="height: 100%; width: 100%; border: solid; position: relative; overflow: hidden;">

    <a href="signup.php" class="signup-button" id="signup">
        Sign up
    </a>

    <div class="or" id="or">
        Or
    </div>

    <a href="login.php" class="login-button" id="login">
        Login
    </a>

</div>

<!-- <a class="test-button" id="test">
    Test
</a> -->

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
        let distFromRadEdge = (radiusLength + elRadius)/Math.tan(toRad(45+(elAngle < 45 ? elAngle : 90-elAngle)));
        let center = elLeft + elWidth/2;
        let betaAngle = toDeg(Math.atan((elHeightDim/2)/(elWidth/2)));
        let trigoLength = Math.cos(toRad(90-(elAngle+betaAngle)))*halfCrosslineLen - elHeightDim/2;
        let tetiva = 2*halfCrosslineLen*Math.sin(toRad(elAngle/2));
        let diff = Math.sqrt(Math.pow(tetiva, 2) - Math.pow((trigoLength), 2));
        let inPiAngle = getIn2PiAngle(elAngleFull, true);
        let upsideDown = inPiAngle > 90;
        let afterFallPos = upsideDown ? elLeft + diff : elLeft - diff;
        // document.getElementById("test").style.left = afterFallPos;

        const acc = 9.8;
        const pxToMet = 0.0002645833;
        const metToPx = 3779.5275591;
        
        let currTime = 0;
        let currHeight = 0;
        let angPerTime = 0;
        let amp = 0;
        let hiddenPart = trigoLength - radiusLength;
        let fallen = false;
        let mass = 5;
        let direction = 1;

        let fall = setInterval(function(){
            currHeight = elHeight - 0.5*acc*currTime*currTime;
            el.style.bottom = currHeight;
            currTime += 0.1;
            if (currHeight < hiddenPart) {
                el.style.bottom = hiddenPart;
                fallen = true;
                if (center > afterFallPos+(upsideDown ? 0 : elWidth) + distFromRadEdge) {
                    direction = -1;
                }
                clearInterval(fall);
            }
        },10)
        
        let intervalTime = 10;
        let rotate = setInterval(function(){
            if (fallen) {
                if (inPiAngle != 0 && inPiAngle != 90 && inPiAngle != 180) {
                    angPerTime += 0.01;
                    amp+=direction*angPerTime;
                    let actualAngle = elAngleFull - amp;
                    let quarterAngle = getAngle(actualAngle);
                    let readyToSettle = false;
                    if ((quarterAngle + angPerTime > 90 || 
                         quarterAngle - angPerTime < 0) && !makeBall) {
                        if (quarterAngle - angPerTime < 0) {
                            direction == -1 ? actualAngle += quarterAngle : actualAngle -= quarterAngle;
                        }
                        if (quarterAngle + angPerTime > 90) {
                            direction == -1 ? actualAngle += (90 - quarterAngle) : actualAngle -= (90 - quarterAngle);
                        }
                        quarterAngle = getAngle(actualAngle)
                        readyToSettle = true;
                    }

                    el.style.rotate = (actualAngle)+'deg';

                    let dist = toRad(angPerTime)*elRadius*pxToMet*metToPx;
                    
                    trigoLength = Math.cos(toRad(90-(quarterAngle+betaAngle)))*halfCrosslineLen - elHeightDim/2;
                    tetiva = 2*halfCrosslineLen*Math.sin(toRad(quarterAngle/2));
                    diff = Math.sqrt(Math.pow(tetiva, 2) - Math.pow((trigoLength), 2));

                    if (makeBall) {
                         elLeft += dist;
                    } else {
                        elLeft = upsideDown ? afterFallPos - diff : afterFallPos + diff;
                    }
                    el.style.left = elLeft;

                    radiusLength = Math.sin(toRad(45+(quarterAngle < 45 ? quarterAngle : 90-quarterAngle)))*Math.sqrt(2)*elRadius-elRadius;
                    distFromRadEdge = (radiusLength + elRadius)/Math.tan(toRad(45+(quarterAngle < 45 ? quarterAngle : 90-quarterAngle)));
                    
                    el.style.bottom = trigoLength - radiusLength;

                    if (readyToSettle) {
                        clearInterval(rotate)
                    }
                }
            }
        },intervalTime)
    }

    function getAngle (elAngle) {
        let spinNum = Math.floor(elAngle/360);
        elAngle -= spinNum*360;
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

    function getIn2PiAngle (angle, onlyPi = false) {
        let in2PiAngle = Math.abs(angle - Math.floor(angle/360)*360);
        if (!onlyPi) { return in2PiAngle; }
        if (in2PiAngle > 180) {
            return in2PiAngle - 180;
        } 
        return in2PiAngle;
    }
    
</script>