<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<body >

    <!-- <div ng-app="" ng-init="myCol='lightblue'">

    <input style="background-color:{{myCol}}" ng-model="myCol" value="{{myCol}}">

    </div> -->


    <!-- <div ng-app="" ng-init="quantity=1;cost=5">

        <p>Total in dollar: {{ quantity * cost }}</p>

    </div> -->

    <!-- <div ng-app="" ng-init="quantity=1;cost=5">

        <p>Total in dollar: <span ng-bind="quantity * cost"></span></p>

    </div> -->

    <!-- <div ng-app="" ng-init="firstName='John';lastName='Doe'">

        <p>The name is {{ firstName + " " + lastName }}</p>

    </div> -->

    <!-- <div ng-app="" ng-init="person={firstName:'John',lastName:'Doe'}">

    <p>The name is {{ person.lastName }}</p>

    </div> -->

    <!-- <div ng-app="" ng-init="points=[1,15,19,2,40]">

    <p>The third result is {{ points[2] }}</p>

    </div> -->

    <!-- <div ng-app="" ng-init="points=[1,15,19,2,40]">

    <p>The third result is <span ng-bind="points[2]"></span></p>

    </div> -->

    <!-- <div ng-app="myApp">...</div>

    <script>

    var app = angular.module("myApp", []);

    </script> -->

    <!-- <div ng-app="myApp" ng-controller="myCtrl">
        {{ firstName + " " + lastName }}
    </div>

    <script>

    var app = angular.module("myApp", []);

    app.controller("myCtrl", function($scope) {
        $scope.firstName = "John";
        $scope.lastName = "Doe";
    });

    </script> -->

    <!-- <div ng-app="myApp" w3-test-directive></div>

    <script>
    var app = angular.module("myApp", []);

    app.directive("w3TestDirective", function() {
        return {
            template : "Eu fui gereado de um construtor !"
        };
    });
</script> -->

<!-- <div ng-app="myApp" ng-controller="myCtrl">
{{ firstName + " " + lastName }}
</div>

<script src="myApp.js"></script>
<script src="myCtrl.js"></script> -->

    <!-- <div ng-app="" ng-init="quantity=1;price=5">

        Quantity: <input type="number" ng-model="quantity">
        Costs:    <input type="number" ng-model="price">

        Total in dollar: {{ quantity * price }}

    </div> -->

    <!-- <div ng-app="" ng-init="names=[
        {name:'Jani',country:'Norway'},
        {name:'Hege',country:'Sweden'},
        {name:'Kai',country:'Denmark'}]">

        <ul>
          <li ng-repeat="x in names">
            {{ x.name + ', ' + x.country }}
          </li>
        </ul>

    </div> -->


    <!-- <div ng-app="myApp" ng-controller="myCtrl">
        Name: <input ng-model="name">
        <h1>You entered: {{name}}</h1>
    </div> -->

    <!-- <form ng-app="" name="myForm">
        Email:
        <input type="email" name="myAddress" ng-model="text">
        <span ng-show="myForm.myAddress.$error.email">Not a valid e-mail address</span>
    </form> -->

    <style>
        input.ng-invalid {
            background-color: lightblue;
        }
        input.ng-valid {
            background-color: lightgreen;
        }
    </style>

    <form ng-app="" name="myForm" ng-init="myText = 'post@myweb.com'">
        Email:
        <input type="email" name="myAddress" ng-model="myText" required>
        <h1>Status</h1>
        {{myForm.myAddress.$valid}}
        {{myForm.myAddress.$dirty}}
        {{myForm.myAddress.$touched}}
    </form>

    <script>
        var app = angular.module('myApp', []);
        app.controller('myCtrl', function($scope) {
            $scope.name = "John Doe";
        });
    </script>

</body>
</html>
