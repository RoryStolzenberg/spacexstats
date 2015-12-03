<!DOCTYPE html>
    <html>
    <div style="width:100%;background-color:#DDDDDD;">
        <table align="center" style="width:800px;border-left:1px solid #CCC;border-right:1px solid #CCC;border-collapse:collapse;background-color:#FFF;">
    
        <tr style="height:80px;font-family:'Brandon Grotesque Thin', 'Brandon Grotesque', 'Helvetica', 'Arial', sans-serif;font-size:20px;background-color:#f2f2f2;color:#666;">
        <td style="width:50px"></td>
        <td><img src="http://spacexstats.com/images/emaillogo.png" alt="logo" />@yield('emailType')</td>
        <td style="width:50px"></td>
        </tr>
    
        <tr style="border-top:1px solid #CCC;height:25px;">
        </tr>
    
        <tr style="font-family:'Noto Sans', 'Helvetica', 'Arial', sans-serif;font-size:16px;">
        <td style="width:50px"></td>
        <td>
            @yield('emailBody')
            <p>Visit <a href="http://spacexstats.com">SpaceX Stats</a> for more information, to track SpaceX's progress via really large numbers, countdown to upcoming launches, and access resources from completed missions if you are a Mission Control subscriber.</p>
        </td>
        <td style="width:50px"></td>
        </tr>
    
        <tr style="border-bottom:1px solid #CCC;height:25px;">
        </tr>
    
        <tr style="height:80px;font-family:'Helvetica', 'Arial', sans-serif;background-color:#F2F2F2;color:#666;font-size:12px;">
        <td style="width:50px"></td>
        <td>You are recieving this email because you're a member of <a href="http://spacexstats.com">spacexstats.com</a>. SpaceX Stats is not in any way associated with Space Exploration Technologies Inc. (SpaceX).</td>
        <td style="width:50px"></td>
        </tr>
    
        </table>
    </div>
</html>