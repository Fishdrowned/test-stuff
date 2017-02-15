/**
 * Created by twsj on 2016/1/28.
 */
+function (w, d) {
    'use strict';
    var MBZ = function () {
        this.canvasWidth = this.canvasHeight = Math.min(400, w.innerWidth - 20);

        this.isMouseDown = false;
        this.isEraser = false;
        this.lastPoint = {x: 0, y: 0};

        this.penWidth = 15;
    };

    //初始化
    MBZ.prototype.init = function () {
        var that = this;
        this.canvas = d.querySelector('canvas');
        this.canvas.width = this.canvasWidth;
        this.canvas.height = this.canvasHeight;

        this.cxt = this.canvas.getContext('2d');
        this.drawGrid();

        this.canvas.onmousedown = function (e) {
            e.preventDefault();
            this.isMouseDown = true;
            var point = that.getCanvasPoint(e.clientX, e.clientY);
            that.lastPoint.x = point.x;
            that.lastPoint.y = point.y;

        };
        this.canvas.onmousemove = function (e) {
            e.preventDefault();
            if (this.isMouseDown) {
                that.draw(e.clientX, e.clientY);
            }
        };
        this.canvas.onmouseup = function (e) {
            e.preventDefault();
            this.isMouseDown = false;
        };
        this.canvas.onmouseout = function (e) {
            e.preventDefault();
            this.isMouseDown = false;
        };

        //手机事件
        d.addEventListener('touchstart', function (e) {
            e.preventDefault();
            this.isMouseDown = true;
            var point = that.getCanvasPoint(e.clientX, e.clientY);
            that.lastPoint.x = point.x;
            that.lastPoint.y = point.y;
        });
        d.addEventListener('touchmove', function (e) {
            e.preventDefault();
            if (this.isMouseDown) {
                that.draw(e.touches[0].clientX, e.touches[0].clientY);
            }
        });
        d.addEventListener('touchend', function (e) {
            e.preventDefault();
            this.isMouseDown = false;
        });

        //功能模块
        //橡皮擦
        var click = 'ontouchstart' in w ? 'touchstart' : 'click';

        d.getElementById('eraser').addEventListener(click, function () {
            that.isEraser = !that.isEraser;
        });

        //清除画布
        d.getElementById('clear').addEventListener(click, function () {
            that.clear();
        });

        //笔型的选择
        d.getElementById('gb').addEventListener(click, function () {
            that.penWidth = 1;
        });

        d.getElementById('mb').addEventListener(click, function () {
            that.penWidth = 15;
        });
    };

    //画米字格
    MBZ.prototype.drawGrid = function () {
        this.cxt.strokeStyle = 'red';
        this.cxt.lineWidth = 6;
        //外边框
        this.cxt.beginPath();
        this.cxt.moveTo(3, 3);
        this.cxt.lineTo(this.canvasWidth - 3, 3);
        this.cxt.lineTo(this.canvasWidth - 3, this.canvasHeight - 3);
        this.cxt.lineTo(3, this.canvasHeight - 3);
        this.cxt.closePath();
        this.cxt.stroke();

        //对角线
        this.cxt.lineWidth = 1;
        this.cxt.beginPath();
        this.cxt.moveTo(3, 3);
        this.cxt.lineTo(this.canvasWidth - 3, this.canvasHeight - 3);
        this.cxt.lineTo(3, this.canvasHeight - 3);
        this.cxt.lineTo(this.canvasWidth - 3, 3);
        this.cxt.stroke();

        //十字线
        this.cxt.beginPath();
        this.cxt.lineTo(3, this.canvasHeight / 2);
        this.cxt.lineTo(this.canvasWidth - 3, this.canvasHeight / 2);
        this.cxt.stroke();

        this.cxt.beginPath();
        this.cxt.lineTo(this.canvasWidth / 2, 3);
        this.cxt.lineTo(this.canvasWidth / 2, this.canvasHeight - 3);
        this.cxt.stroke();
    };

    //写字
    MBZ.prototype.draw = function (x, y) {
        this.cxt.strokeStyle = '#000';
        if (this.isEraser) {
            this.cxt.strokeStyle = '#fff';
        }
        this.cxt.lineWidth = this.penWidth;
        this.cxt.lineJoin = 'round';
        this.cxt.lineCap = 'round';
        this.cxt.beginPath();
        this.cxt.moveTo(this.lastPoint.x, this.lastPoint.y);
        var point = this.getCanvasPoint(x, y);
        this.cxt.lineTo(point.x, point.y);
        this.cxt.stroke();

        this.drawGrid();

        this.lastPoint.x = point.x;
        this.lastPoint.y = point.y;
    };

    //清除
    MBZ.prototype.clear = function () {
        this.cxt.clearRect(0, 0, this.canvasWidth, this.canvasHeight);
        this.drawGrid();
    };

    //根据鼠标位置获取canvas中的坐标点
    MBZ.prototype.getCanvasPoint = function (x, y) {
        var rect = this.canvas.getBoundingClientRect();
        return {x: x - rect.left, y: y - rect.top}
    };

    var mbz = new MBZ();
    mbz.init();
}(window, document);
