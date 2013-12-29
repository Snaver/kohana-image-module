kohana-image-module (WIP)
=========================

Kohana 2 image module for manipulating/outputting/caching images. Utilises [https://github.com/Intervention/image](Intervention\image) heavily.

Overview
========

Supports file types jpg, png, gif (input and output). Parameters are passed encrypted to the script via the 'q' query string.  

Image handling
------
* If source image is smaller, will center image (x & y) on transparent canvas, HOWEVER there are a few rules..  
	* If width AND height provided the resulting image (canvas) will be those exact dimensions  
	* If only one dimension is given, resulting image will only be centered along that axis  
* If only width is given, image will be resized using correct aspect  
* If only height is given, image will be resized using correct aspect  

TODO
====
* Helpers for resizing images locally and saving (Instead of requesting via URL)  
* Figure out how to handle transparent bg on JPG images  
* Caching  
* Resize type implementation (Canvas, centering, direct 1:1 etc)  
* Security checks  
* Benchmarking/Performance/Bottlenecks etc  
* Improve this README..  