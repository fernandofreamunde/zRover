# zRover
Mars Rover Control

This project was made as an assessment for a job interview.

### Objective
Write a simple control station for fictional rovers in the mars surface.

A squad of robotic rovers is to be landed by NASA on a plateau on Mars. This plateau, which is curiously rectangular, must be navigated by the rovers so that their on
board cameras can get a complete view of the surrounding terrain to send back to Earth. 
A rover's position is represented by a combination of an x and y co-ordinates and a letter representing one of the four cardinal compass points. 
The plateau is divided up into a grid to simplify navigation. 
An example position might be 0, 0, N, which means the rover is in the bottom left corner and facing North.
In order to control a rover, NASA sends a simple string of letters. The possible letters are 'L', 'R' and 'M'. 
'L' and 'R' makes the rover spin 90 degrees left or right respectively, without moving from its current spot.
'M' means move forward one grid point, and maintain the same heading.
Assume that the square directly North from (x, y) is (x, y+1).

### Setup

- [ ] clone this project
- [ ] on this project folder run composer install

### Usage
- [ ] on this project folder run php bin/console rover:constrol
- [ ] on this project folder run php bin/console rover:swarm (for more than one rover)
