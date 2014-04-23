<?php

/**
* pmpTheme class
*/
class pmpTheme extends Theme 
{
    private $font_color        = '#0044CC';
    private $background_color  = '#d6dbd6';
    private $back_inside_color = '#c4c9c4';
    private $axis_color        = '#d6dbd6';
    private $grid_color        = '#3366CC';

    function GetColorList() {
        return array(
            '#FF0000',
            '#FFFF00',
            '#00FF00',
            '#00FFFF',
            '#0000FF',
            '#FF00FF',
            '#A00000',
            '#A0A000',
            '#00A000',
            '#00A0A0',
            '#0000A0',
            '#A000A0',
            '#800000',
            '#808000',
            '#008000',
            '#008080',
            '#000080',
            '#800080',
        );
    }

    function SetupGraph($graph) {

        // graph
        /*
        $img = $graph->img;
        $height = $img->height;
        $graph->SetMargin($img->left_margin, $img->right_margin, $img->top_margin, $height * 0.25);
        */
        $graph->SetFrame(true, $this->background_color);
        $graph->SetMarginColor($this->background_color);
        $graph->SetBackgroundGradient($this->back_inside_color, $this->back_inside_color, GRAD_HOR, BGRAD_PLOT);

        // legend
        $graph->legend->SetFrameWeight(0);
        $graph->legend->Pos(0.5, 0.85, 'center', 'top');
        $graph->legend->SetFillColor($this->back_inside_color);
        $graph->legend->SetLayout(LEGEND_HOR);
        $graph->legend->SetColumns(3);
        $graph->legend->SetShadow(false);
        $graph->legend->SetMarkAbsSize(5);

        // xaxis
        $graph->xaxis->title->SetColor($this->font_color);  
        $graph->xaxis->SetColor($this->axis_color, $this->font_color);    
        $graph->xaxis->SetTickSide(SIDE_BOTTOM);
        $graph->xaxis->SetLabelMargin(10);
                
        // yaxis
        $graph->yaxis->title->SetColor($this->font_color);  
        $graph->yaxis->SetColor($this->axis_color, $this->font_color);    
        $graph->yaxis->SetTickSide(SIDE_LEFT);
        $graph->yaxis->SetLabelMargin(8);
        $graph->yaxis->HideLine();
        $graph->yaxis->HideTicks();
        $graph->xaxis->SetTitleMargin(15);

        // font
        $graph->title->SetColor($this->font_color);
        $graph->subtitle->SetColor($this->font_color);
        $graph->subsubtitle->SetColor($this->font_color);

//        $graph->img->SetAntiAliasing();
    }


    function SetupPieGraph($graph) {

        // graph
        $graph->SetFrame(true, $this->background_color);
        $graph->SetMarginColor($this->background_color);


        // legend
        $graph->legend->SetFillColor($this->back_inside_color);
        $graph->legend->SetFrameWeight(0);
        $graph->legend->Pos(0.5, 0.80, 'center', 'top');
        $graph->legend->SetLayout(LEGEND_HOR);
        $graph->legend->SetColumns(4);

        $graph->legend->SetShadow(false);
        $graph->legend->SetMarkAbsSize(5);

        // title
        $graph->title->SetColor($this->font_color);
        $graph->subtitle->SetColor($this->font_color);
        $graph->subsubtitle->SetColor($this->font_color);

        $graph->SetAntiAliasing();
    }


    function PreStrokeApply($graph) {
        if ($graph->legend->HasItems()) {
            $img = $graph->img;
            $height = $img->height;
            $graph->SetMargin($img->left_margin, $img->right_margin, $img->top_margin, $height * 0.25);
        }
    }

    function ApplyPlot($plot) {

        switch (get_class($plot))
        { 
            case 'GroupBarPlot':
            {
                foreach ($plot->plots as $_plot) {
                    $this->ApplyPlot($_plot);
                }
                break;
            }

            case 'AccBarPlot':
            {
                foreach ($plot->plots as $_plot) {
                    $this->ApplyPlot($_plot);
                }
                break;
            }

            case 'BarPlot':
            {
                $plot->Clear();

                $color = $this->GetNextColor();
                $plot->SetColor($color);
                $plot->SetFillColor($color);
                $plot->SetShadow('red', 3, 4, false);
                break;
            }

            case 'LinePlot':
            {
                $plot->Clear();
                $plot->SetColor($this->GetNextColor().'@0.4');
                $plot->SetWeight(2);
//                $plot->SetBarCenter();
                break;
            }

            case 'PiePlot':
            {
                $plot->SetCenter(0.5, 0.45);
                $plot->ShowBorder(false);
                $plot->SetSliceColors($this->GetThemeColors());
                break;
            }

            case 'PiePlot3D':
            {
                $plot->SetSliceColors($this->GetThemeColors());
                break;
            }
    
            default:
            {
            }
        }
    }
}


?>
